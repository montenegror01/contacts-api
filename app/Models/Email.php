<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $table = 'emails';
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = ['contacto_id', 'email'];

    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }
}
