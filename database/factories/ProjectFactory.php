<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Project;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'desc' => $this->faker->paragraphs(1, true),
            'image' => null,
            'date' => now(),
            'technologies' => 'php, javascript, mysql',
            'responsive' => 'Si',
            'role' => 'FullStack',
            'link' => 'www.google.com'
        ];
    }
}
