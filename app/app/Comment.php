<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    
    public function post(){
        
        return $this->belongsTo(Post::class);
    }
    
    public function parent() {
        
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    
    public function children() {
        
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
