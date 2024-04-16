<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();

            $table->date('date_schedule');

            $table->integer('day');
            $table->integer('month');
            $table->integer('year');
            $table->integer('turn'); // 1 -DIURNO 2 - NOTURNO

            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_unit');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('schedule');
    }
};
