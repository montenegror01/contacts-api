<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    use HasFactory;
    protected $table = 'telefonos';
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = ['contacto_id', 'numero','tipo'];

    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }
}
