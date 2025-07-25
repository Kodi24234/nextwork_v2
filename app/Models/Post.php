<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    //
    protected $fillable = [
        'user_id', // post owner id
        'body',    //  content of the post
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function likes(): BelongsToMany
    {

        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
    }
    public function isLikedByAuthUser(): bool
    {

        if (! Auth::check()) {
            return false;
        }
        return $this->likes()->where('user_id', Auth::id())->exists();
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
