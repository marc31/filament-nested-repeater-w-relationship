<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = collect([
            [
                'title' => 'red'
            ],
            [
                'title' => 'blue'
            ],
            [
                'title' => 'green'
            ],
            [
                'title' => 'yellow'
            ],
            [
                'title' => 'black'
            ],
            [
                'title' => 'white'
            ]
        ]);


        $colors->each(function ($color) {
            Color::create($color);
        });
    }
}
