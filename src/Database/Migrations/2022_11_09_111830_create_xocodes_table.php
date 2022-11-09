<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use  Xoxoday\Disclaimer\Models\Xocode;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xocodes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 40);
            $table->enum('used', ['Yes','No','In-Queue']); // To be marked used only after Spin the Wheel is completed
            $table->dateTime('creation_date');
            $table->integer('win_segment')->default(0);
        });

         //default data entry for the code table
         if (Xocode::count() <= 0) {
            Artisan::call('db:seed', [
                '--class' => 'CodesSeeder',
                '--force' => true]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xocodes');
    }
};
