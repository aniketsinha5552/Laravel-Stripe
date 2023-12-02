<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            'name' => 'Basic',
            'stripe_plan' => 'price_1OIXyvSCZRp3uFSHWXc7XFqr',
            'price' => 100,
            'desc' => 'basic laravel app plan'
        ]);
        DB::table('plans')->insert([
            'name' => 'Pro',
            'stripe_plan' => 'price_1OIXzSSCZRp3uFSHvBDJwka4',
            'price' => 200,
            'desc' => 'pro laravel app plan'
        ]); DB::table('plans')->insert([
            'name' => 'Premium',
            'stripe_plan' => 'price_1OIY0ASCZRp3uFSHMH0YSV6u',
            'price' => 500,
            'desc' => 'premium laravel app plan'
        ]);
    }
}
