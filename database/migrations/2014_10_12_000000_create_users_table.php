<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;
use App\Enums\OnlineEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first')->nullable();
            $table->string('last')->nullable();
            $table->string('other_names')->nullable();
            $table->string('email')->unique()->nullable();


            $table->string('user_token')->nullable();
            $table->string('status')->default('uninvited');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();

            $table->string('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('role')->default(Role::$type_default);
            $table->string('type')->default(User::$type_default);
            $table->boolean('online')->default(OnlineEnum::Default->value); //for chating /discussion
            // $table->boolean('status')->default(1);
            // $table->uuid('deleted')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};