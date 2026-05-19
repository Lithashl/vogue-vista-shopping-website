<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    
    public function getCategoryNameAttribute()
    {
        return $this->attributes['name'];
    }
}
