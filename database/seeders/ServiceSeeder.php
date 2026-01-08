<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Haircut', 'Classic haircut and styling', 45, 15.00],
            ['Beard Trim', 'Beard shaping and trimming', 30, 10.00],
            ['Haircut + Beard', 'Full package: haircut + beard', 60, 22.00],
            ['Hair Coloring', 'Basic coloring service', 90, 35.00],
            ['Manicure', 'Basic manicure', 60, 20.00],
            ['Massage', 'Relaxing massage session', 60, 30.00],
        ];

        foreach ($items as [$title, $desc, $duration, $price]) {
            Service::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'description' => $desc,
                    'duration_minutes' => $duration,
                    'price' => $price,
                    'is_active' => true,
                ]
            );
        }
    }
}
