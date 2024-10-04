<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;
    protected $table = 'contactos';
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = [
        'nombre', 
        'notas', 
        'fecha_nacimiento', 
        'pagina_web', 
        'empresa'
    ];
    
    public function telefonos()
    {
        return $this->hasMany(Telefono::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    public function direcciones()
    {
        return $this->hasMany(Direccion::class);
    }
}