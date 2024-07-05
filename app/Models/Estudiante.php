<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Estudiante extends Authenticatable
{
    use HasFactory, Notifiable;
    public $timestamps = false;
    protected $table= 'estudiante';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'pin',
    ];

    protected $hidden = [
        'pin',
    ];
    public function setPinAttribute($value)
    {
        $this->attributes['pin'] = Hash::make($value);
    }
}
