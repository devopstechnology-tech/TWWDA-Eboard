<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('modifications', function (Blueprint $table) {
            // $table->increments('id');
            $table->uuid('id')->primary();
            // $table->nullableMorphs('modifiable');
            // $table->nullableMorphs('modifier');
            $table->string('modifiable_type')->nullable();
            $table->string('modifiable_id')->nullable();  // Manually specifying as string
            $table->string('modifier_type')->nullable();   // Manually specifying as string
            $table->string('modifier_id')->nullable();  // Manually specifying as string
            $table->boolean('active')->default(true);
            $table->boolean('is_update')->default(true);
            $table->integer('approvers_required')->default(1);
            $table->integer('disapprovers_required')->default(1);
            $table->string('md5');
            $table->json('modifications');
            $table->string('action')->default('created');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['md5', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modifications');
    }
};