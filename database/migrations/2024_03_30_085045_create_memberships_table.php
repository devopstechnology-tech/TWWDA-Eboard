<?php

declare(strict_types=1);

use App\Enums\SignEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('memberable_id');
            $table->string('memberable_type');
            $table->string('meeting_id');
            $table->string('member_id');
            $table->string('user_id');
            $table->string('location');
            $table->string('signature');
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
        Schema::dropIfExists('memberships');
    }
};