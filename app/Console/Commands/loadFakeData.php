<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Artisan;

class loadFakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loadFakeData';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start...');
        $result = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
            'api_token' => str_random(60),
        ]);
        if($result){
            $this->info('Admin created');
            $this->info('login: admin@admin.com');
            $this->info('password: secret');
        }
        $this->info('start create fake data');
        $bar = $this->output->createProgressBar(500000);
        $bar->start();
        for($i=0;$i<500000;$i++){
            Artisan::call('db:seed', [
                '--class' => 'FakeUsersAndBooks',
            ]);
            $bar->advance();
        }
        $bar->finish();
        $this->info('Done');
    }
}
