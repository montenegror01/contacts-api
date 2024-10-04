<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Direccion extends Model
{
    use HasFactory;
    protected $table = 'direcciones';
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = ['contacto_id', 'direccion', 'ciudad', 'estado', 'codigo_postal'];

    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }
}