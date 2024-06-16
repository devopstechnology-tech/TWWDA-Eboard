<?php

declare(strict_types=1);

use App\Enums\RSVPEnum;
use App\Enums\InviteEnum;
use App\Enums\AttendanceEnum;
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
        Schema::create('attendances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('location')->nullable();
            $table->string('schedule_id')->nullable();
            $table->string('membership_id')->nullable();
            $table->string('invite_status')->default(InviteEnum::Default->value); //accept reject  invited
            $table->string('rsvp_status')->default(RSVPEnum::Default->value); //signed or unsigned
            $table->string('attendance_status')->default(AttendanceEnum::Default->value); //mark attendance
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};