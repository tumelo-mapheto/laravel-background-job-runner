<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class JobRunCommand extends Command
{
    protected $signature = 'job:run {class} {method} {parameters?*}';
    protected $description = 'Run a job method in the background';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $className = $this->argument('class');
        $methodName = $this->argument('method');
        $parameters = $this->argument('parameters') ? json_decode(implode(' ', $this->argument('parameters')), true) : [];

        // Validate if class exists
        if (!class_exists($className)) {
            Log::error("Class $className not found.");
            $this->error("Class $className not found.");
            return;
        }

        // Validate if the method exists in the class
        if (!method_exists($className, $methodName)) {
            Log::error("Method $methodName not found in class $className.");
            $this->error("Method $methodName not found in class $className.");
            return;
        }

        try {
            // Instantiate the class
            $job = new $className();

            // Ensure parameters are passed correctly as an array
            if (!is_array($parameters)) {
                $parameters = [];
            }

            // Log the input parameters to verify the structure
            Log::info("Executing $className::$methodName with parameters: " . json_encode($parameters));

            // Call the method with the provided parameters
            call_user_func_array([$job, $methodName], $parameters);

            // Log success
            Log::info("Job $className::$methodName executed successfully.");
            $this->info("Job $className::$methodName executed successfully.");
        } catch (\Exception $e) {
            // Log and display error
            Log::error("Error executing $className::$methodName: " . $e->getMessage());
            $this->error("Error executing $className::$methodName: " . $e->getMessage());
        }
    }
}
