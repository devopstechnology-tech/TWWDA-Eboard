<?php

use App\Enums\SignEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conflicts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('address')->nullable();
            $table->longText('nature')->nullable();
            $table->integer('amount')->nullable();
            $table->dateTime('ceased_date')->nullable();
            $table->longText('remarks')->nullable();
            $table->string('meeting_id');
            $table->string('membership_id');
            $table->string('signature')->nullable();
            $table->string('status')->default(SignEnum::Default->value);//signed or unsigned
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conflicts');
    }
};