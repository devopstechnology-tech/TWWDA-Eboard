<?php

use App\Enums\HeldEnum;
use App\Enums\ApprovalEnum;
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
        Schema::create('almanacs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type')->nullable();
            $table->longText('purpose')->nullable();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->string('budget')->default(0);
            $table->string('status')->default(ApprovalEnum::Default->value); //signed or unsigned
            $table->string('held')->default(HeldEnum::Default->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almanacs');
    }
};