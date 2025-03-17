<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name');
            $table->date('dob');
            $table->string('whatsapp', 10);
            $table->string('alt_no', 10)->nullable();
            $table->string('email')->unique();
            $table->text('address');
            $table->string('city');
            $table->unsignedBigInteger('state_id');
            $table->string('pincode', 6);
            $table->string('business')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('inspirer')->nullable();
            $table->string('cooperation_field')->nullable();
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members'); // Drop the table if it exists
    }
}