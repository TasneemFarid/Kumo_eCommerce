<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    function rel_to_user(){
        return $this->belongsTo(User::class, 'added_by');
    }
    
    function rel_to_category(){
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }
}