<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Direccion;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Direccion>
 */
class DireccionFactory extends Factory
{
    protected $model = Direccion::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'direccion' => $this->faker->streetAddress,
            'ciudad' => $this->faker->city,
            'estado' => $this->faker->state,
            'codigo_postal' => $this->faker->postcode,
        ];
    }
}
