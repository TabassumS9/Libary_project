<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(category::class);
    }
    public function author(){
        return $this->belongsTo(author::class);
    }
    public function subcategory(){
        return $this->belongsTo(subcategory::class);
    }
}
