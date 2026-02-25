<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'username',
        'activity',
        'description',
        'ip_address',
        'user_agent',
    ];

    /**
     * Disable automatic timestamps.
     *
     * @var bool
     */
    public $timestamps = false;
}
