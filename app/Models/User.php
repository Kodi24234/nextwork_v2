<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class)->orderBy('start_date', 'desc');
    }
    public function education(): HasMany
    {

        return $this->hasMany(Education::class)->orderBy('start_date', 'desc');
    }
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'skill_user');
    }
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->latest();
    }
    public function likedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function sentConnectionRequests()
    {
        return $this->hasMany(Connection::class, 'requester_id');
    }

    /**
     * Defines the connection requests this user has received.
     */
    public function receivedConnectionRequests()
    {
        return $this->hasMany(Connection::class, 'addressee_id');
    }
    public function getFriends()
    {
        // Get all accepted connections where this user was the requester
        $friendsFromSentRequests = $this->sentConnectionRequests()
            ->where('status', 'accepted')
            ->with('addressee') // Eager load the user model
            ->get()
            ->pluck('addressee'); // Pluck just the user object

        // Get all accepted connections where this user was the addressee
        $friendsFromReceivedRequests = $this->receivedConnectionRequests()
            ->where('status', 'accepted')
            ->with('requester') // Eager load the user model
            ->get()
            ->pluck('requester'); // Pluck just the user object

        // Merge the two collections together
        return $friendsFromSentRequests->merge($friendsFromReceivedRequests);
    }
    public function getConnectionStatusWith(User $otherUser): ?string
    {
        // Check if a connection exists where this user sent the request
        $sentRequest = Connection::where('requester_id', $this->id)
            ->where('addressee_id', $otherUser->id)
            ->first();
        if ($sentRequest) {
            return $sentRequest->status;
        }

        // Check if a connection exists where this user received the request
        $receivedRequest = Connection::where('requester_id', $otherUser->id)
            ->where('addressee_id', $this->id)
            ->first();
        if ($receivedRequest) {
            // From the other user's perspective, our status is 'pending' if we haven't accepted
            // Let's return a special status for the UI to handle
            if ($receivedRequest->status === 'pending') {
                return 'pending_approval'; // A custom status for our UI
            }
            return $receivedRequest->status;
        }

        return null; // No connection exists
    }

    public function getConnectionWith(User $otherUser)
    {
        return Connection::where(function ($query) use ($otherUser) {
            $query->where('requester_id', $this->id)
                ->where('addressee_id', $otherUser->id);
        })->orWhere(function ($query) use ($otherUser) {
            $query->where('requester_id', $otherUser->id)
                ->where('addressee_id', $this->id);
        })->first();
    }
    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }
    public function jobApplications(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_applications')->withTimestamps();
    }
}
