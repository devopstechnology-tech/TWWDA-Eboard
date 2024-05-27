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
        Schema::create('assignee_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('task_id')->nullable();
            $table->string('membership_id')->nullable();
            $table->string('status')->default(TaskEnum::Backlog->value); //signed or unsigned
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignee_tasks');
    }
};
