<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = [
            'Cool Buddy Avatar',
            'Keep Fighting Buddy',
            'Itachi',
            'Eagle Bird',
            'Phantom Assassin'
        ];

        for ($i=1; $i <= 12; $i++) { 
            Avatar::create([
                'name' => $name[$i - 1],
                'price' => rand(50, 100000),
                'path' => '/assets/images/avatar/'.$i.'.png'
            ]);
        }
    }
}