<?php

namespace LogCleaner;

use Illuminate\Support\ServiceProvider;

class LogCleanerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->commands([
            LogClearCommand::class
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind(CleanerInterface::class, LogCleaner::class);
    }
}
