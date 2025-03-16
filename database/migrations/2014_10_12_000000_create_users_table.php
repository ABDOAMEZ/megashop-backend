<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('google_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('phone')->default('');
            $table->string('country_of_citizenship');
            $table->string('country_of_birth');
            $table->date('date_of_birth');
            $table->string('national_ID');
            $table->string('identity_proof');
            $table->string('country_of_issue');
            $table->date('date_of_expiry');
            $table->string('residential_address');
            $table->string('card_Number');
            $table->string('date_expires_card');
            $table->string('card_holder_name');
            $table->enum('role', ['buyer', 'seller', 'admin'])->default('buyer');
            $table->rememberToken();
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
