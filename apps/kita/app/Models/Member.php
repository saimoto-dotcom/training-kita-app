<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Member
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Member extends Authenticatable
{
    use HasFactory;

    /**
     * 書き込み可能なカラム.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * シリアライズ時に隠す属性.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * コメントとのリレーション
     */
    public function articleComments()
    {
        return $this->hasMany(ArticleComment::class);
    }

    /**
     * 作成日時の降順でソートするスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatestRegistered(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }
}
