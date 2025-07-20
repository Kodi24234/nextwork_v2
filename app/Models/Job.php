<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    //
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'company_id',
        'title',
        'description',
        'location',
        'salary',
        'type',
        'status',
    ];

    /**
     * Get the company that owns the job posting.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function applicants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'job_applications')->withTimestamps();
    }
}
