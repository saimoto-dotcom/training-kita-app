<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // タグマスタ（固定）
        $tagNames = [
            'Laravel',
            'PHP',
            'Eloquent',
            'ルーティング',
            '認証',
            '設計',
            'テスト',
            'Docker',
        ];

        // タグを全件登録（重複防止）
        foreach ($tagNames as $name) {
            ArticleTag::firstOrCreate([
                'name' => $name,
            ]);
        }

        // 登録済みタグを取得
        $tags = ArticleTag::all();

        // 記事を生成して、タグをランダムに紐付け
        Article::factory(50)->create()->each(function ($article) use ($tags) {
            // 20% はタグなしの記事にする
            if (rand(1, 5) === 1) {
                return;
            }

            // タグあり（1〜5個）
            $article->tags()->attach(
                $tags->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
