<?php

use Illuminate\Database\Seeder;
use App\Models\Agent;

class AgentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Agent::class, 10)->create();
    }
}
