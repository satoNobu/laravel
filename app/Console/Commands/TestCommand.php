<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // \Log::info("test");
        // return "test_command";
        $defaultIndex = 'Taylor';
        $name = $this->choice(
            'What is your name?',
            ['Taylor', 'Dayle'],
            $defaultIndex
        );

        $this->info('The command was successful!'.$name);
        $this->newLine();
        $this->line('Display this on the screen');
        $this->newLine(3);

        // $this->table(
        //     ['Name', 'Email'],
        //     User::all(['name', 'email'])->toArray()
        // );

        // $users = $this->withProgressBar(User::all(), function ($user) {
        //     $this->performTask($user);
        // });
    }
}
