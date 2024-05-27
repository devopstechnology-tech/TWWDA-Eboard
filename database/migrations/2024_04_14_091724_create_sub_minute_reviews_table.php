<?php

declare(strict_types=1);

use App\Enums\UpdateEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sub_minute_reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('minute_review_id')->nullable();
            $table->string('sub_detail_minute_id')->nullable();
            $table->string('membership_id')->nullable();//commenter durng reading the minutes
            $table->longText('description')->nullable();
            $table->string('status')->default(UpdateEnum::Default->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_minute_reviews');
    }
};
