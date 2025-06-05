<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OlaMundo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ola:mundo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Ola Mundo');
    }
}
