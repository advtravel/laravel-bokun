<?php

namespace Adventures\LaravelBokun\Commands;

use Illuminate\Console\Command;

class LaravelBokunCommand extends Command
{
    public $signature = 'laravel-bokun';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
