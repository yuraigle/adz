<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SampleCommand extends Command
{
    protected $signature = "sample:sample";
    protected $description = "Example command";

    public function handle()
    {
        $this->info("OK");
        return;
    }
}
