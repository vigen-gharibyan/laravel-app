<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'posts';

    protected $fillable = [
        'title',
        'content',
        'created_by',
        'updated_by',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::user()) {
                $model->created_by = Auth::user()->id;
                $model->updated_by = Auth::user()->id;
            }
        });

        static::updating(function ($model) {
            if (Auth::user()) {
                $model->updated_by = Auth::user()->id;
            }
        });
    }

    /***** Relations *****/
    function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    function updatedBy()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }
}
