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
        Schema::create('discussion_assignees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('discussion_id')->nullable();
            $table->string('user_id')->nullable(); // default if classese involved
            $table->string('assignable_id')->nullable();
            $table->string('assignable_type')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_assignees');
    }
};