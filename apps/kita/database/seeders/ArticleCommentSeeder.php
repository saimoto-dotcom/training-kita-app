<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Database\Seeder;

class ArticleCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::all()->each(function ($article) {
            ArticleComment::factory()
                ->count(3)
                ->create([
                    'article_id' => $article->id,
                ]);
        });
    }
}
