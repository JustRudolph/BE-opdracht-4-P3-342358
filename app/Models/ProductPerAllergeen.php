<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPerAllergeen extends Model
{
    use HasFactory;
    
    protected $table = 'product_per_allergeens';
    public $timestamps = false;
    
    protected $fillable = [
        'ProductId',
        'AllergeenId',
        'IsActief',
        'Opmerking'
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId');
    }

    public function allergeen()
    {
        return $this->belongsTo(Allergeen::class, 'AllergeenId');
    }
}
