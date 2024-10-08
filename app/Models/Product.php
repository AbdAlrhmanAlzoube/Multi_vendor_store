<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Scopes\StoreScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'compare_price',
        'option',
        'rating',
        'featured',
        'status',
        'category_id', // Add other fields if necessary
    ];

    //GLOBLSCOPE

    protected static function booted() //تتنغد بشكل تلقائي
    {
        static::addGlobalScope('store', new StoreScope());
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public static function rules()
    {
        return [
            // 'category_id' => 'nullable|exists:categories,id',
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                // تأكد من أن الاسم فريد في نطاق معين إذا لزم الأمر
                // 'unique:products,name',
            ],
            // 'slug' => 'required|string|unique:products,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1048576|dimensions:min_width=100,min_height=100',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'option' => 'nullable|json',
            'rating' => 'nullable|numeric|min:0|max:5',
            'featured' => 'nullable|boolean',
            'status' => 'required|in:active,draft,archived',
        ];
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    //Accesser
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.kcnpnm.org/global_graphics/default-store-350x350.jpg';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return  round(100 - (100 * $this->price / $this->compare_price),1); //method number_format
    }
}
