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
        Schema::create('settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('logo')->nullable();
            $table->string('textlogo')->nullable();
            $table->string('name')->nullable();
            $table->string('about')->nullable();
            $table->string('website')->nullable();
            $table->string('iso')->nullable();
            $table->string('isologo')->nullable();
            $table->longText('address')->nullable();
            $table->string('county')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->longText('pspdkitlicencekey')->nullable();
            $table->json('mailtype')->nullable();
            $table->json('mailtypes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
