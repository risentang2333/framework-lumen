<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HelloWorld extends Command
{
    protected $signature = 'hello';

    protected $description = 'echo';

    public function handle()
    {
        echo 1;exit;
    }
}