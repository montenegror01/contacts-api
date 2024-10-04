<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Contacto::factory(5000)->create()->each(function ($contacto) {
            $contacto->telefonos()->createMany(\App\Models\Telefono::factory(3)->make()->toArray());
            $contacto->emails()->createMany(\App\Models\Email::factory(2)->make()->toArray());
            $contacto->direcciones()->createMany(\App\Models\Direccion::factory(1)->make()->toArray());
        });
    }
}
