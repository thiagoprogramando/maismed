<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model {

    use HasFactory;

    protected $table = 'schedule';

    protected $fillable = [
        'date_schedule',

        'id',
        'id_user',
        'id_unit',

        'day',
        'month',
        'year',
        'turn',

        'situation',
        'observation'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    protected $appends = ['user_first_name'];

    public function getUserFirstNameAttribute() {
        return $this->user ? $this->user->firstName() : '---';
    }    

    public function unit() {
        return $this->belongsTo(Unit::class, 'id_unit');
    }

    public function turnLabel() {
        switch ($this->turn) {
            case 1:
                return 'Diurno';
                break;
            case 2:
                return 'Noturno';
                break;
            default:
                return 'Desconhecido';
        }
    }

    public function situationLabel() {
        switch ($this->situation) {
            case 1:
                return '✔';
                break;
            default:
                return ' ';
        }
    }
}
