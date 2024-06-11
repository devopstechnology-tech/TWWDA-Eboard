<?php

declare(strict_types=1);


use App\Enums\HeldEnum;
use App\Enums\PublishEnum;
use App\Enums\ScheduletypeEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->string('conference')->nullable();
            $table->string('link')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default(PublishEnum::Default->value);
            $table->string('type')->default(ScheduletypeEnum::Default->value);
            $table->longText('description')->nullable();
            $table->string('owner_id')->nullable();
            // Adds 'meetingable_id' and 'meetingable_type'
            $table->string('meetingable_type');
            $table->string('meetingable_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};