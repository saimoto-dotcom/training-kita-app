<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\Member;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $titleBase = $this->faker->randomElement([
            'Laravelでコメント機能を実装する方法',
            'Eloquentリレーション設計の考え方',
            'Route Model Bindingを使った実装パターン',
            'FactoryとSeederを活用した開発効率化',
            '実務で使えるLaravel設計の基本',
        ]);

        return [
            // 同テーマ × バリエーション
            'title' => $titleBase . '（' . $this->faker->word . '編）',

            // 技術記事っぽい本文
            'contents' => $this->faker->paragraphs(4, true),

            // 会員との紐づけ
            'member_id' => Member::factory(),
        ];
    }
}
