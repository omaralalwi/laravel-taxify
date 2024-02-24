<?php

namespace Omaralalwi\LaravelTaxify\Console\Commands;

use Illuminate\Console\Command;

class RunTaxifyTestsCommand extends Command
{
    protected $signature = 'taxify:test';

    protected $description = 'Run tests for the Laravel Taxify package.';

    public function handle()
    {
        $this->info('Running Laravel Taxify tests...');

        $result = $this->laravel->call('test', ['--path' => 'tests']);

        if ($result === 0) {
            $this->info('Tests passed successfully.');
        } else {
            $this->error('Tests failed.');
        }
    }
}
