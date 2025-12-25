<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'contents',
        'member_id',
        'article_id',
    ];

    /**
     * コメント投稿者（会員）
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * 紐づく記事
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
