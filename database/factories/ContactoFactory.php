<?php

namespace Database\Factories;

use App\Models\Contacto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactoFactory extends Factory
{
    protected $model = Contacto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'notas' => $this->faker->sentence,
            'fecha_nacimiento' => $this->faker->date(),
            'pagina_web' => $this->faker->url,
            'empresa' => $this->faker->company,
        ];
    }
}