<?php

use Illuminate\Database\Seeder;

class FakeUsersAndBooks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create()->each(function ($user) {
            $user->books()->save(factory(App\Book::class)->make());
        });
    }
}
