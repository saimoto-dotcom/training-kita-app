<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticleComment>
 */
class ArticleCommentFactory extends Factory
{
    protected $model = ArticleComment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // コメント本文ベース（日本語）
        $commentBase = $this->faker->randomElement([
            [
                'とても参考になりました。',
                '特にリレーション設計の説明が分かりやすかったです。',
            ],
            [
                '実装手順が整理されていて助かりました。',
                '同じような機能を作っていたので参考にします。',
            ],
            [
                'Route Model Bindingの使い方が理解できました。',
                '実務でもそのまま使えそうですね。',
            ],
            [
                'コメント機能の設計で悩んでいたので助かりました。',
                'バリデーションの考え方も勉強になります。',
            ],
        ]);

        return [
            // 改行を含むコメント本文
            'contents' => implode("\n", $commentBase),

            // 会員との紐づけ
            'member_id' => Member::factory(),

            // 記事との紐づけ
            'article_id' => Article::factory(),
        ];
    }
}
