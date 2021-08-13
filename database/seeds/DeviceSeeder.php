<?php

use Illuminate\Database\Seeder;

use App\Device;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Device::create([
            'name' => "Ball",
            'field' => "field1",
            'description' => "Test Device",
            'image' => 'spalding.jpg'
        ]);
    }
}
