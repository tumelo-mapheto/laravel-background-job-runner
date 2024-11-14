<?php

namespace App\Utils;

use Illuminate\Support\Facades\Log;

class BackgroundJobRunner
{
    public static function run($className, $methodName, $parameters = [], $retryCount = 3)
    {
        // Validate class and method
        if (!self::isValidJob($className, $methodName)) {
            Log::error("Invalid job attempt: $className::$methodName");
            return;
        }

        $parameters = escapeshellarg(json_encode($parameters)); // Sanitize parameters

        // Command to run the job in the background
        $phpPath = PHP_BINARY; // Gets the PHP executable path
        $artisanPath = base_path('artisan');
        $command = "$phpPath $artisanPath job:run $className $methodName $parameters > /dev/null 2> storage/logs/job_errors.log &";

        try {
            // Execute the command to run the job in the background
            exec($command);
            Log::info("Job $className::$methodName started successfully.");
        } catch (\Exception $e) {
            Log::error("Error executing background job: " . $e->getMessage());
            self::retryJob($className, $methodName, $parameters, $retryCount);
        }
    }

    private static function retryJob($className, $methodName, $parameters, $retryCount)
    {
        if ($retryCount > 0) {
            Log::info("Retrying job $className::$methodName. Retries left: $retryCount");
            self::run($className, $methodName, $parameters, $retryCount - 1);
        } else {
            Log::error("Job $className::$methodName failed after maximum retries.");
        }
    }

    private static function isValidJob($className, $methodName)
    {
        // Only allow specific classes to run in the background
        $allowedClasses = ['App\\Jobs\\SampleJob']; // Add more valid classes here
        return in_array($className, $allowedClasses);
    }
}
