<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazijn extends Model
{
    use HasFactory;
    
    protected $table = 'magazijns';
    public $timestamps = false;
    
    protected $fillable = [
        'ProductId',
        'VerpakkingsEenheid',
        'AantalAanwezig',
        'IsActief',
        'Opmerking'
    ];

    protected $casts = [
        'VerpakkingsEenheid' => 'decimal:2',
        'AantalAanwezig' => 'integer',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId');
    }
}
