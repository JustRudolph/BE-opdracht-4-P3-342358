<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'products';
    public $timestamps = false;
    
    protected $fillable = [
        'Naam',
        'Barcode',
        'IsActief',
        'Opmerking'
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function magazijn()
    {
        return $this->hasOne(Magazijn::class, 'ProductId');
    }

    public function leveranciers()
    {
        return $this->belongsToMany(Leverancier::class, 'product_per_leveranciers', 'ProductId', 'LeverancierId')
            ->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering');
    }

    public function allergeens()
    {
        return $this->belongsToMany(Allergeen::class, 'product_per_allergeens', 'ProductId', 'AllergeenId');
    }

    public function productPerLeveranciers()
    {
        return $this->hasMany(ProductPerLeverancier::class, 'ProductId');
    }
}
