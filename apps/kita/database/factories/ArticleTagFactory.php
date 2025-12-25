<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ArticleTag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticleTag>
 */
class ArticleTagFactory extends Factory
{
    protected $model = ArticleTag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tags = [
            'Laravel',
            'PHP',
            'Eloquent',
            'ルーティング',
            '認証',
            '設計',
            'テスト',
            'Docker',
        ];

        return [
            // fake()を使って配列からランダムに1つ選ぶ
            'name' => $this->faker->randomElement($tags),
        ];
    }
}
