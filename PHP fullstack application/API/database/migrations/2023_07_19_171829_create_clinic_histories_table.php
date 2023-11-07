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
        Schema::create('clinic_histories', function (Blueprint $table) {
            $table->id();
            $table->date('birth_date');
            $table->enum('gender', ['Male', 'Female', 'Non-binary', 'Other']); // Using ENUM for genger
            $table->string('phone',45);
            $table->string('address',250);
            $table->string('city',45);
            $table->string('email',250);
            $table->string('medical_conditions',250);
            $table->string('current_medications',250);
            $table->string('allergies',250);
            $table->string('personal_habits',250);
            $table->string('frequency_visits',250);
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_histories');
    }
};
