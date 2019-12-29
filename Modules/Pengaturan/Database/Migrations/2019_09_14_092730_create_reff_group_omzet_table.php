<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReffGroupOmzetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reff_metode_hitung_pajak', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id')->unsigned();
            $table->string('nama');
            $table->boolean('status')->default(1);
            
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
        Schema::dropIfExists('reff_metode_hitung_pajak');
    }
}
