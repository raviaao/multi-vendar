<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
            $table->boolean('phone_verified')->default(false);
            $table->string('phone_verification_code')->nullable();
            $table->timestamp('phone_verification_sent_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->integer('otp_attempts')->default(0);
            $table->timestamp('otp_blocked_until')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone_verified',
                'phone_verification_code',
                'phone_verification_sent_at',
                'phone_verified_at',
                'otp_attempts',
                'otp_blocked_until'
            ]);
        });
    }
};
