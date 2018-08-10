<?php

declare(strict_types=1);

namespace LogCleaner;

use Carbon\Carbon;

class LogCleaner implements CleanerInterface
{

    /**
     * @var LogCleanerConfig
     */
    protected $config;

    public function __construct(LogCleanerConfig $cleanerConfig = null)
    {
        $this->config = $cleanerConfig ?? new LogCleanerConfig();
    }

    /**
     * Комбинируем все действия с фалами
     *
     * @throws \Exception
     */
    public function run()
    {
        if (!\File::exists($this->config->getLogDirectoryPath())) {
            throw new \Exception('Такой дериктории не существует.');
        }

        //удаляем фйлы которые в которые давно не писали
        $this->remove(
            $this->takeOldFiles(
                \File::allFiles($this->config->getLogDirectoryPath())
            )
        );

        //переименовываем все фалы бльше определеннного размера, чтобы в них больше не писал логер
        $this->dumpFile(
            $this->takeFilesByFileSize(
                \File::allFiles($this->config->getLogDirectoryPath())
            )
        );
    }

    /**
     * @param  \SplFileInfo[] $fileInfoList
     * @return \SplFileInfo[]
     */
    protected function takeOldFiles(array $fileInfoList): array
    {
        return \array_filter(
            $fileInfoList,
            function (\SplFileInfo $fileInfo) {
                if ($fileInfo->getExtension() === $this->config->getLogExtension()) {
                    return Carbon::now()
                            ->diffInDays(
                                Carbon::createFromTimestamp(
                                    $fileInfo->getMTime()
                                )
                            ) >= $this->config->getMaxDayOfLive();
                }

                return false;
            }
        );
    }

    /**
     * @param  array $fileInfoList
     * @return array
     */
    protected function takeFilesByFileSize(array $fileInfoList): array
    {

        return \array_filter(
            $fileInfoList,
            function (\SplFileInfo $fileInfo) {
                return $this->bytesToMBytes($fileInfo->getSize()) >= $this->config->getMaxFileSize();
            }
        );
    }

    /**
     * @param  \SplFileInfo[] $fileInfoList
     * @return void
     */
    protected function dumpFile(array $fileInfoList)
    {
        \array_walk(
            $fileInfoList,
            function (\SplFileInfo $fileInfo) {
                if ($fileInfo->getExtension() === $this->config->getLogDumpExtension()) {
                    return;
                }

                $target =
                    $fileInfo->getPath() .
                    '/' .
                    $fileInfo->getBasename('log') .
                    $this->config->getLogDumpExtension();

                \File::move($fileInfo->getPathname(), $target);
            }
        );
    }

    /**
     * @param  \SplFileInfo[] $fileInfoList
     * @return void
     */
    protected function remove(array $fileInfoList)
    {
        \array_walk(
            $fileInfoList,
            function (\SplFileInfo $fileInfo) {
                \File::delete($fileInfo->getPathname());
            }
        );
    }

    //байты в мегабайты с округлением до инта
    protected function bytesToMBytes($bytes): int
    {
        return (int)($bytes / pow(1024, 2));
    }

    /**
     * @return LogCleanerConfig
     */
    public function getConfig(): LogCleanerConfig
    {
        return $this->config;
    }

    /**
     * @param LogCleanerConfig $config
     */
    public function setConfig(LogCleanerConfig $config)
    {
        $this->config = $config;
    }
}
