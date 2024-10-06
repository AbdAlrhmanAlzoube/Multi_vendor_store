<?php

namespace App\Models;

use App\Rules\Filtir;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule as ValidationRule;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status',
        'parent_id'
    ];

    public function parent() 
    {
        return $this->belongsTo(Category::class, 'parent_id')
        ->withDefault([
            'name'=>'-'
        ]);
    }
   /// قي حال ما بدي اشتخدم liftjoin في الا index بعمل علاقى وهنيك بجيبها من with
    //category=>manyproduct
    //product=>onecategory

    public function products()
    {
        return $this->hasMany(Product::class,'category_id','id');
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? null, function ($builder, $value) {
            $builder->where('categories.name', 'like', "%{$value}%");
        });

        $builder->when($filters['status'] ?? null, function ($builder, $value) {
            $builder->where('categories.status', '=', $value);
        });
    }

    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                //ValidationRule::filter('laravel', 'php', 'html'), app service provider use rule
                ValidationRule::unique('categories', 'name')->ignore($id),
                new Filtir(['laravel', 'php', 'html']),
            ],
            'parent_id' => 'nullable|int|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1048567|dimensions:min_width=100,min_height=100',
            'status' => 'required|in:active,archived',
        ];
    }
}
