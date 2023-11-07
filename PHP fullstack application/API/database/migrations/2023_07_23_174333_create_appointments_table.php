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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name',45);
            $table->string('phone',45);
            $table->string('howdiduhearaboutus',250);
            $table->date('date');
            $table->time('time');
            $table->enum('specialist', ['Hygiene & Prevention', 'Dental Crowns', 'Dental Bridges', 'Dental Fillings', 'Root Canal', 'Oral Surgery', 'Implants']);
            $table->string('comment',250);
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
