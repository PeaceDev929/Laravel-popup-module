<?php

namespace Database\Factories;

use App\Popup;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class PopupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Popup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = (new \Faker\Factory())::create();

        return [
            'title' => $faker->text,
            'content' => $faker->text,
            'image' => $faker->text,
            'bt_name' => $faker->text, 
        ];
    }
}
