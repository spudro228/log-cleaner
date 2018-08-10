<?php

declare(strict_types=1);

namespace LogCleaner;

class LogCleanerConfig
{

    /**
     * @var string
     */
    protected $logDirectoryPath;

    /**
     * @var int
     */
    protected $maxDayOfLive;

    /**
     * @var string
     */
    protected $logExtension;

    /**
     * Megabyte
     *
     * @var int
     */
    protected $maxFileSize;

    /**
     * @var string
     */
    protected $logDumpExtension;

    public function __construct(
        string $logDirectoryPath = null,
        int $maxDayOfLive = 30,
        string $logExtension = 'log',
        int $maxFileSize = 10000,
        string $logDumpExtension = 'log-dump'
    ) {
        $this->logDirectoryPath = $logDirectoryPath ?? (storage_path() . '/logs');
        $this->maxDayOfLive = $maxDayOfLive;
        $this->logExtension = $logExtension;
        $this->maxFileSize = $maxFileSize;
        $this->logDumpExtension = $logDumpExtension;
    }

    /**
     * @return string
     */
    public function getLogDirectoryPath(): string
    {
        return $this->logDirectoryPath;
    }

    /**
     * @param string $logDirectoryPath
     */
    public function setLogDirectoryPath(string $logDirectoryPath)
    {
        $this->logDirectoryPath = $logDirectoryPath;
    }

    /**
     * @return int
     */
    public function getMaxDayOfLive(): int
    {
        return $this->maxDayOfLive;
    }

    /**
     * @param int $maxDayOfLive
     */
    public function setMaxDayOfLive(int $maxDayOfLive)
    {
        $this->maxDayOfLive = $maxDayOfLive;
    }

    /**
     * @return string
     */
    public function getLogExtension(): string
    {
        return $this->logExtension;
    }

    /**
     * @param string $logExtension
     */
    public function setLogExtension(string $logExtension)
    {
        $this->logExtension = $logExtension;
    }

    /**
     * @return int
     */
    public function getMaxFileSize(): int
    {
        return $this->maxFileSize;
    }

    /**
     * @param int $maxFileSize
     */
    public function setMaxFileSize(int $maxFileSize)
    {
        $this->maxFileSize = $maxFileSize;
    }

    /**
     * @return string
     */
    public function getLogDumpExtension(): string
    {
        return $this->logDumpExtension;
    }

    /**
     * @param string $logDumpExtension
     */
    public function setLogDumpExtension(string $logDumpExtension)
    {
        $this->logDumpExtension = $logDumpExtension;
    }
}
