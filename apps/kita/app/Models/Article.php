<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Article
 *
 * @property int $id
 * @property string $title
 * @property string $contents
 * @property int $member_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property-read Member $member
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ArticleTag> $tags
 */
class Article extends Model
{
    use HasFactory;
    use SoftDeletes; // 論理削除対応

    protected $fillable = [
        'title',
        'contents',
        'member_id',
    ];

    /**
     * 投稿者（会員）とのリレーション
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    /**
     * タグとのリレーション（多対多）
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            ArticleTag::class,
            'article_article_tags', // 中間テーブル名
            'article_id',           // このモデルの外部キー
            'article_tag_id'        // 相手モデルの外部キー
        );
    }
}
