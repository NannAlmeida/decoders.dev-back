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
            $table->uuid()->primary();
            $table->string('fullname')->nullable(false);
            $table->string('nickname')->nullable(false);
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('url')->nullable();
            $table->string('github')->nullable();
            $table->string('email')->nullable(false);
            $table->string('phoneNumber')->nullable();
            $table->string('password')->nullable(false);
            $table->string('photo')->nullable();
            $table->string('banner')->nullable();
            $table->date('birthdate')->nullable(false);
            $table->boolean('moderator')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
};
