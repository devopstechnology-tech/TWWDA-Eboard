<?php

use App\Enums\EditEnum;
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
        Schema::create('chats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('discussion_id')->nullable();
            $table->string('assignee_sender_id')->nullable(); // User who sends the message
            $table->string('assignee_receiver_id')->nullable(); // User who receives the message
            $table->string('message')->nullable();
            $table->string('editstatus')->default(EditEnum::Default->value);
            $table->string('file')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};