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
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            //self update
            $table->string('avatar')->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('idpassportnumber')->unique()->nullable();
            $table->string('gender_id')->nullable();
            $table->longText('about')->nullable();
            // address
            $table->string('address')->nullable();
            $table->string('home_county_id')->nullable();
            $table->string('residence_county_id')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('nationality')->nullable();
            // self documents
            $table->string('kra_pin')->nullable();
            $table->string('member_cv')->nullable();
            // official
            $table->string('establishment')->nullable();
            $table->string('title')->nullable();
            $table->string('appointing_authority')->nullable();
            $table->string('appointnment_date')->nullable();
            $table->string('appointment_letter')->nullable();
            $table->string('appointment_end_date')->nullable();
            $table->string('serving_term')->nullable();
            $table->string('current_period')->nullable();
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};