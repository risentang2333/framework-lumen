<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Mail;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';

    protected $description = 'Backup the database';

    protected $process;

    public function __construct()
    {
        parent::__construct();

        $this->process = new Process(sprintf(
            'mysqldump -u%s -p%s %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            storage_path('database/'.date('Y-m-d').'.sql')
        ));
    }

    public function handle()
    {
        try {
            $this->process->mustRun();
            // $content = '数据库备份成功.';
            // $toMail  = 'magicheart@163.com';
            // Mail::raw($content, function ($message) use ($toMail) {
            //     $message->subject('【备份】数据库 - ' .date('Y-m-d H:i:s'));
            //     $message->to($toMail);
            // });

            $this->info('The backup has been proceed successfully.');
        } catch (ProcessFailedException $exception) {
            throw $exception;exit;
            $content = '数据库备份失败.';
            $toMail  = 'magicheart@163.com';
            Mail::raw($content, function ($message) use ($toMail) {
                $message->subject('【备份】数据库 - ' .date('Y-m-d H:i:s'));
                $message->to($toMail);
            });
            $this->error('The backup process has been failed.');
        }
    }
}