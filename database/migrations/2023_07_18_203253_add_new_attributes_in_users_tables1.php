<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * LA fonction up permet d'ajouter des champs dans une table à partir de php artisan migrate
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //ajout de nouveau champ dans la table users
            $table->integer('is_verified')
                    ->default(0);

            $table->string('activation_code', 255)
                    ->nullable();

            $table->string('activation_token', 255)
                    ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 
        });
    }
};