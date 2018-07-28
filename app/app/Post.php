<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{    
    
    protected $fillable = ['created_at'];
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function tag(){
        
        return $this->belongsToMany(Tag::class);
    }
    
    public function category(){
        
        return $this->belongsTo('App\Category');
    }
}
