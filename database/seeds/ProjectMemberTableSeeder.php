<?php

use Illuminate\Database\Seeder;

class ProjectMemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Entities\ProjectTask::truncate();
        factory(\App\Entities\ProjectMember::class, 40)->create();
        
    }
}
