<?php

declare(strict_types=1);

use App\Enums\TaskEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->string('duedate')->nullable();
            $table->string('description')->nullable();
            $table->string('assigneetype')->nullable();
            $table->string('assigneestatus')->nullable();
            $table->string('meeting_id')->nullable();
            $table->string('board_id')->nullable();
            $table->string('committee_id')->nullable();
            $table->string('status')->default(TaskEnum::Backlog->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
