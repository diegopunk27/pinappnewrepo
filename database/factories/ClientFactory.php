<?php

namespace Database\Factories;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $birthdate = strval($this->faker->date($format = 'Y-m-d', $max = 'now'));
        return [
            'name' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'birthdate' => $birthdate,
            'age' => call_user_func(function() use ($birthdate){
                $formatBirthdate= Carbon::parse($birthdate);
                $newAge = Carbon::now()->diffInYears($formatBirthdate);
                return $newAge;
            }),
        ];
    }
}
