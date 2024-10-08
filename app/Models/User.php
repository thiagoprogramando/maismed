<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {

    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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

    public function firstName() {
        $names = explode(' ', $this->name);

        if (count($names) >= 2) {
            return $names[0] . ' ' . $names[1];
        }

        return $names[0];
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
