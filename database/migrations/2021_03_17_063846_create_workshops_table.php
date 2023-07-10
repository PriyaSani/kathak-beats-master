<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->integer('engagement_type');
            $table->integer('engagement_mode');
            $table->integer('studio_id')->nullable();
            $table->string('title');
            $table->string('poster');
            $table->string('description');
            $table->double('price');
            $table->longText('about');
            $table->longText('content');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('frequency');
            $table->tinyInteger('booking')->default(1);
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_delete')->default(0);
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
        Schema::dropIfExists('workshops');
    }
}
