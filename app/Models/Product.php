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
        'store_id',
        'category_id', // Add other fields if necessary
    ];

    protected $hidden=[
        'created_at','updated_at','deleted_at','image'
    ];

    protected $appends=[    //return response json url alowes
        'image_url', 
    ];

    //GLOBLSCOPE

    protected static function booted() //تتنغد بشكل تلقائي
    {
        static::addGlobalScope('store', new StoreScope());

        static::creating(function(Product $product)
        {
            $product->slug=str::slug($product->name);
        });
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
            'category_id' => 'required|sometimes|exists:categories,id',
            'store_id'=>'sometimes|required|exists:stores,id',
            'name' => [
                'sometimes',   //use api endpoint update if request input name then requierd else not required
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
            'price' => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
            'option' => 'nullable|json',
            'rating' => 'nullable|numeric|min:0|max:5',
            'featured' => 'nullable|boolean',
            'status' => 'in:active,draft,archived',
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
        if (!$this->compare_price || $this->compare_price == 0) {
            return 0; // Avoid division by zero by returning 0
        }
        return round(100 - (100 * $this->price / $this->compare_price), 1); 
    }
    

    public function scopeFilter(Builder $builder, $filters)
    {
        $option = array_merge([            //merge value[]=>value[]key==key in 2 array
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($option['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });
        $builder->when($option['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });
        
        $builder->when($option['tag_id'], function ($builder, $value) {
            
            $builder->whereExists(function ($query) use ($value) {
                $query->select(1)
                ->from('product_tag')
                ->whereRaw('product_id = porduct.id')
                ->where('tag_id', $value);
            });
        });
            // $builder->whereRaw('id IN(SELECT product_id FORM product_tag WHERE tag_id = ?)'[$value]);
            // $builder->whereRaw('EXISTS (SELECT 1 FORM product_tag WHERE tag_id = ? AND product_id = productss.id)'[$value]);
          //  $builder->whereHas('tags', function ($builder) use ($value)    //has =>return all product with releshion tags //donthave 
            //{
               // $builder->where('id', $value); //two join
           // });
       
    }
}
 