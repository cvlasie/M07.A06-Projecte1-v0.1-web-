<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Visibility;

class VisibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $visibilities = [
            ['name' => 'public'],
            ['name' => 'contacts'],
            ['name' => 'private'],
        ];

        foreach ($visibilities as $visibility) {
            Visibility::create($visibility);
        }
    }
}
