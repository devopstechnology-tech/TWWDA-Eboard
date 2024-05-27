<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::connection(config('activitylog.database_connection'))->create(config('activitylog.table_name'), function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->uuid('id')->primary();
            $table->string('log_name')->nullable();
            $table->text('description');
            // $table->nullableMorphs('subject', 'subject');
            $table->string('subject_type')->nullable();
            $table->string('subject_id')->nullable(); // Changed from morphs to separate string declaration
            $table->string('event')->nullable();  // Event type column.
            // $table->nullableMorphs('causer', 'causer');
            $table->string('causer_type')->nullable();
            $table->string('causer_id')->nullable(); // Changed from morphs to separate string declaration
            $table->json('properties')->nullable();
            $table->uuid('batch_uuid')->nullable();  // Batch UUID for grouping log entries.
            $table->timestamps();
            $table->index('log_name');
        });
    }

    public function down(): void
    {
        Schema::connection(config('activitylog.database_connection'))->dropIfExists(config('activitylog.table_name'));
    }
};