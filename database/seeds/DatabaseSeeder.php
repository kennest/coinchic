<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ArtistSeeder::class);
        $this->call(PlaceSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(EventSeeder::class);
    }
}
