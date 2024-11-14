<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

class SampleJob
{
    /**
     * Sample method to be run as a background job.
     *
     * @param string $message
     * @return void
     */
    public function execute()
    {
        Log::info("SampleJob executed with message");
    }
}
