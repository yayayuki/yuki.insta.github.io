<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    # To count the number of posts that the category has
    # See admin/categories/index table.
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }
}
