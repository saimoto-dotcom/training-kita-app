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
        // タイトル用ベース
        $titleBase = $this->faker->randomElement([
            'Laravelでコメント機能を実装する方法',
            'Eloquentリレーション設計の考え方',
            'Route Model Bindingを使った実装パターン',
            'FactoryとSeederを活用した開発効率化',
            '実務で使えるLaravel設計の基本',
        ]);

        // 本文用ベース（日本語固定）
        $contentsBase = [
            '本記事ではLaravelを用いたコメント機能の実装方法について解説します。',
            'Eloquentリレーションを適切に設計することで、保守性の高いコードが書けます。',
            '実装時にはバリデーションや認可処理も忘れずに行いましょう。',
            '最後に、実務でよくある落とし穴についても触れていきます。',
        ];

        return [
            // 同テーマ × バリエーション
            'title' => $titleBase . '（' . $this->faker->word . '編）',

            // 日本語本文（改行あり）
            'contents' => implode("\n\n", $contentsBase),

            // 会員との紐づけ
            'member_id' => Member::factory(),
        ];
    }
}
