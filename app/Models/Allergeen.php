<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergeen extends Model
{
    use HasFactory;
    
    protected $table = 'allergeens';
    public $timestamps = false;
    
    protected $fillable = [
        'Naam',
        'Omschrijving',
        'IsActief',
        'Opmerking'
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_per_allergeens', 'AllergeenId', 'ProductId');
    }
}
