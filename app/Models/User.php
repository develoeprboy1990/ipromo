<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = "user";

    public $timestamps = false;

    protected $primaryKey = 'UserID';

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'user_jobs','user_id', 'job_id')->withPivot(['reply','status']);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class,'user_id');
    }
}
