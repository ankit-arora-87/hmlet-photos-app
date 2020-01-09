<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model 
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'photos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'captions', 'user_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}