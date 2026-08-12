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
             Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('jobs')->nullable();
            $table->integer('experience')->unsigned()->default(0);
            $table->decimal('price', 10, 2)->nullable()->default(0);
            $table->string('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('Description')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade'); 
            $table->timestamps();
        });
        
    }
    public function down(): void
    {
         Schema::dropIfExists('profile');
    }
};
