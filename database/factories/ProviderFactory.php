<?php

namespace Database\Factories;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email1' => $this->faker->unique()->safeEmail,
            'email2' => $this->faker->unique()->safeEmail,
            'phones' => $this->faker->phoneNumber,
            'address1' => $this->faker->address,
            'address2' => $this->faker->address,
        ];
    }

}
