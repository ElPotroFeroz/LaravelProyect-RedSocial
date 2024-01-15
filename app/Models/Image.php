<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;   
    protected $table = 'images';
    
    public function coments() {
        return $this->hasMany('App\Models\Coment')->orderBy('id', 'desc');
    }
    
    public function likes() {
        return $this->hasMany('App\Models\Like');
    }
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');       
    }
}
