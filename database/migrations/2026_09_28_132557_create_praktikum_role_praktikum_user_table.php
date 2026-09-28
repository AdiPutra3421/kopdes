<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('praktikum_role_praktikum_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('praktikum_user_id')->constrained('praktikum_users')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('praktikum_roles')->cascadeOnDelete();
            $table->unique(['praktikum_user_id', 'role_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('praktikum_role_praktikum_user');
    }
};
