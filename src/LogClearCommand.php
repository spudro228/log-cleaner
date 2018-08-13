<?php

declare(strict_types=1);

namespace LogCleaner;

use Illuminate\Console\Command;

class LogClearCommand extends Command
{
    protected $signature = 'log:clear '
    . '{--logDirectoryPath= : Директория где хранятся логи}'
    . '{--maxDayOfLive=30 : Число дней, когда послоедний раз был использован файл. Файл удалоится, если он стардше }'
    . '{--maxFileSize=10000 : Размер фала в МЕГАБАЙТАХ. Все фалы размером больше чем это значения будут переименованы}'
    . '{--logExtension=log}'
    . '{--logDumpExtension=log-dump : Директория где хранятся логи}';

    protected $description = 'Чистит все логи в папке';

    protected $cleaner;

    /**
     * Create a new command instance.
     *
     * @param CleanerInterface|LogCleaner $cleaner
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
        $config = new LogCleanerConfig();
        if ($this->option('logDirectoryPath')) {
            $config->setLogDirectoryPath($this->option('logDirectoryPath'));
        }
        $config->setMaxDayOfLive((int)$this->option('maxDayOfLive'));
        $config->setMaxFileSize((int)$this->option('maxFileSize'));
        $config->setLogExtension($this->option('logExtension'));
        $config->setLogDumpExtension($this->option('logDumpExtension'));

        $this->cleaner->setConfig($config);

        $this->info('LogClear start...');
        try {
            $this->cleaner->run();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->info('LogClear finish.');
    }

}
