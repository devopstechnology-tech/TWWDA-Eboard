<?php

use App\Enums\TaskEnum;
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
        Schema::create('taskstatuses', function (Blueprint $table) {
            $table->uuid('id')->primary();            $table->string('option_id')->nullable();
            $table->string('task_id')->nullable();
            $table->string('assignee_task_id')->nullable();
            $table->string('date')->nullable();
            $table->string('status')->default(TaskEnum::OnProgress->value);//signed or unsigned
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taskstatuses');
    }
};
