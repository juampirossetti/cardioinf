<?php

use Illuminate\Database\Seeder;

use App\Models\Membership\Membership;

class MembershipTableSeeder extends Seeder
{

    public $membership = ['name' => 'basic'];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $membership = $this->membership;

        Membership::create($membership);
    }
}