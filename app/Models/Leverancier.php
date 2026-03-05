<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    protected $table = 'leveranciers';
    public $timestamps = false;
    
    protected $fillable = [
        'Naam',
        'ContactPersoon',
        'LeverancierNummer',
        'Mobiel',
        'ContactId',
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
        return $this->belongsToMany(Product::class, 'product_per_leveranciers', 'LeverancierId', 'ProductId')
            ->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering');
    }

    public function productPerLeveranciers()
    {
        return $this->hasMany(ProductPerLeverancier::class, 'LeverancierId');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'ContactId');
    }
}
