<?php

if (!function_exists('runBackgroundJob')) {
    /**
     * Helper function to run background jobs.
     *
     * @param string $className
     * @param string $methodName
     * @param array $parameters
     * @return void
     */
    function runBackgroundJob($className, $methodName, $parameters = [])
    {
        \App\Utils\BackgroundJobRunner::run($className, $methodName, $parameters);
    }
}
