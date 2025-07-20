<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'headline',
        'location',
        'summary',
        'website_url',
        'linkedin_url',
        'profile_picture_path',
        'user_id',
    ];

    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture_path
        ? asset('storage/' . $this->profile_picture_path)
        : 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
