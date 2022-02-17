<?php

namespace Database\Factories\Dealskoo\Comment\Models;

use Dealskoo\Comment\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'guest_name' => $this->faker->name,
            'guest_email' => $this->faker->email,
            'score' => $this->faker->numberBetween(0, 5),
            'comment' => $this->faker->text,
            'approved' => $this->faker->boolean,
            'parent_id' => null
        ];
    }
}
