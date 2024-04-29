<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'crm',
        'cpfcnpj',
        'email',
        'password',
        'address',
        'type'
    ];

    public function typeLabel() {
        switch ($this->type) {
            case 1:
                return 'Administrador';
                break;
            case 2:
                return 'Supervisor';
                break;
            case 3:
                return 'Médico';
                break;
            default:
                return 'Desconhecido';
        }
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
