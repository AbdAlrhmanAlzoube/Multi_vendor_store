<?php

namespace App\Models;

use App\Rules\Filtir;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public static function rules($id = 0)
    {
        return [
           'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
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
