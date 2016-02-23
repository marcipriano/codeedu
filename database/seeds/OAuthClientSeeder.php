<?php

use Illuminate\Database\Seeder;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Entities\User::truncate();
        factory(\App\Entities\OAuthClient::class)->create([
            'id' => "appid1",
            'secret' => "secret",
            'name' => "laravelApp"
        ]);
        
        factory(\App\Entities\OAuthClient::class, 10)->create();
                
    }
}
