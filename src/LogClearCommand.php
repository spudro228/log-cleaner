<?php

namespace LogCleaner;

use Illuminate\Console\Command;

class LogClearCommand extends Command
{
    protected $signature = 'log:clear';

    protected $description = 'Чистит все логи в папке';

    protected $cleaner;

    /**
     * Create a new command instance.
     *
     * @param CleanerInterface $cleaner
     */
    public function __construct(CleanerInterface $cleaner)
    {
        parent::__construct();
        $this->cleaner = $cleaner;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {

        $this->info('LogClear start...');
        try {
            $this->cleaner->run();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->info('LogClear finish.');
    }

}

