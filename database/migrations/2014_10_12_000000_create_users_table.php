<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('crm')->nullable();
            $table->string('cpfcnpj')->nullable();

            $table->string('email')->unique()->nullable();
            $table->string('password');

            $table->integer('type'); // 1 - Master 2 - Supervisor 3 - Colaborador

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
