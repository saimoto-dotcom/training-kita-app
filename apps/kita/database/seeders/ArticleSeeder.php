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
        // 5個のタグを生成
        $tags = ArticleTag::factory(5)->create();

        // 記事を生成
        Article::factory(50)->create()->each(function ($article) use ($tags) {
            // 各記事にランダムにタグを紐付け（1〜5個）
            $article->tags()->attach(
                $tags->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
