<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    //GLOBLSCOPE

    protected static function booted() //تتنغد بشكل تلقائي
    {
        static::addGlobalScope('store', new StoreScope());
     
    }

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
