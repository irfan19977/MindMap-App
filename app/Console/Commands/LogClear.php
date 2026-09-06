<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LogClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Laravel log files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logPath = storage_path('logs');
        
        if (!file_exists($logPath)) {
            $this->error('Log directory does not exist.');
            return 1;
        }

        $files = glob($logPath . '/*.log');
        
        if (empty($files)) {
            $this->info('No log files found to clear.');
            return 0;
        }

        foreach ($files as $file) {
            if (file_put_contents($file, '') === false) {
                $this->error("Failed to clear log file: " . basename($file));
                return 1;
            }
        }

        $this->info('Laravel log files cleared successfully.');
        return 0;
    }
}
