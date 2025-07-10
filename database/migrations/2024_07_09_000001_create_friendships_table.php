<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('friend_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Evitar duplicados (A no puede ser amigo de B dos veces)
            $table->unique(['user_id', 'friend_id']);
            
            // Evitar relaciones bidireccionales (A-B y B-A)
            // $table->check('user_id < friend_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('friendships');
    }
};
