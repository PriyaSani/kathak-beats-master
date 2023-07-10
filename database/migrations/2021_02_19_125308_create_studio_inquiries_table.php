<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudioInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studio_inquiries', function (Blueprint $table) {
            $table->id();
            $table->date('inquiry_date');
            $table->string('full_name');
            $table->string('email');
            $table->string('contact_number');
            $table->string('whatsapp_number');
            $table->text('address');
            $table->enum('status', array('PENDING', 'CONVERTED', 'MISSED'))->default('PENDING');
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
        Schema::dropIfExists('studio_inquiries');
    }
}
