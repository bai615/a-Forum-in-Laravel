<?php

use Illuminate\Database\Seeder;

class ThreadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Reply::truncate();
        \App\Thread::truncate();
        \App\User::truncate();
        \App\Channel::truncate();

        //
        factory(App\Thread::class, 50)->create()->each(function($thread) {
            factory('App\Reply',10)->create(['thread_id' => $thread->id]);
        });
    }
}
