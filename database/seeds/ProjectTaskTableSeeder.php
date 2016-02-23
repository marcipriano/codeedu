<?php

use Illuminate\Database\Seeder;

class ProjectTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Entities\ProjectTask::truncate();
        factory(\App\Entities\ProjectTask::class, 80)->create();
        
    }
}
