<?php

declare(strict_types=1);

namespace LogCleaner;

interface CleanerInterface
{
    /**
     * @return void
     */
    public function run();
}