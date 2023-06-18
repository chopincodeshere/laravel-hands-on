<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //public $timestamps = false;

    //TABLE
    public $table = 'posts';

    //FILLABLE
    protected $fillable = [
        'user_id',
        'title',
        'description'
    ];

    //HIDDEN
    protected $hidden = [];

    //APPENDS
    protected $appends = [];

    //WITH
    protected $with = [];

    //CASTS
    protected $casts = [];

    //RELATIONSHIPS
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function files()
    {
        return $this->hasMany(PostFile::class);
    }
    public function file()
    {
        return $this->hasOne(PostFile::class);
    }
    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    //ATTRIBUTES
    //public function getExampleAttribute()
    //{
    //    return $data;
    //}

}
