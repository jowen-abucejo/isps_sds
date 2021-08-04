<?php

namespace Database\Factories;

use App\Models\ScholarshipApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScholarshipApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ScholarshipApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'scholarship_id' => $this->faker->numberBetween(1, 6),
            'student_id' => $this->faker->numberBetween(1, 1000),
            'course_id' => $this->faker->numberBetween(1, 11),
            'year_level' => $this->faker->numberBetween(1, 4),
            'sem' => $this->faker->numberBetween(1, 2),
            'sy' => $this->faker->randomElement(['2018-2019','2019-2020','2020-2021']),
            'gpa' => $this->faker->randomFloat(3, 1, 2),
            'lowest_grade' => $this->faker->randomFloat(3, 1, 3), 
            'num_of_units' => $this->faker->numberBetween(20, 30),
            'has_inc' => $this->faker->numberBetween(0, 1),
            'has_drop' => $this->faker->numberBetween(0, 1),
            'status' => $this->faker->randomElement(['OK']),
        ];
    }
}
