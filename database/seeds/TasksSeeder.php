<?php

use Illuminate\Database\Seeder;

use App\Task;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::truncate();

        $faker = \Faker\Factory::create();
        
        for ($i = 0; $i < 50; $i++) {
            Task::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
            ]);
        }
    }
}
