<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->uuid('uuid')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->enum('type_document', ['CPF', 'CNPJ']);
            $table->string('document')->unique();
            $table->string('identity_document')->unique();
            $table->string('mothers_name');
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->foreignId('address_id')->constrained('addresses')->nullable();
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
}
