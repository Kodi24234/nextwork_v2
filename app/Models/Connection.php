<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    //
    protected $fillable = [
        'requester_id',
        'addressee_id',
        'status',
    ];
    public function requester()
    {return $this->belongsTo(User::class, 'requester_id');}
    public function addressee()
    {return $this->belongsTo(User::class, 'addressee_id');}
}
