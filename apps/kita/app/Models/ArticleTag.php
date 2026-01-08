<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ArticleTag
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Article> $articles
 */
class ArticleTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * 記事とのリレーション（多対多）
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(
            Article::class,
            'article_article_tags', // 中間テーブル名
            'article_tag_id',      // このモデルの外部キー
            'article_id'           // 相手モデルの外部キー
        );
    }
}
