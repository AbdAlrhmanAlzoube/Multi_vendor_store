<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey='user_id';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birth_day',  
        'gender',
        'city',
        'state',
        'street_address',
        'postal_code',
        'country',
        'locale',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
