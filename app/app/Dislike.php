<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
{
    protected $fillable = ['dislike'];
    
    public function post(){
        
        return $this->belongsTo(Post::class);
        
    }
    
    public function user(){
        
        return $this->belongsTo(User::class);
        
    }
}
