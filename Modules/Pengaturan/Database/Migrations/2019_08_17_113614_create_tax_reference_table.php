<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reff_pajak', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id')->unsigned();
            $table->string('nama');
            $table->boolean('status')->default(1);
            
            $table->timestamps();
        });

        Schema::create('reff_jenis_pajak', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id')->unsigned();
            $table->string('nama');
            $table->boolean('status')->default(1);
            
            $table->timestamps();
        });

        Schema::create('reff_kategori_pajak', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id')->unsigned();
            $table->string('nama');
            $table->boolean('status')->default(1);
            
            $table->timestamps();
        });

        Schema::create('reff_jenis_penetapan_pajak', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id')->unsigned();
            $table->string('nama');
            $table->boolean('status')->default(1);
            
            $table->timestamps();
        });

        Schema::create('reff_jenis_pelaporan_pajak', function (Blueprint $table) {
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
        Schema::dropIfExists('reff_pajak');
        Schema::dropIfExists('reff_jenis_pajak');
        Schema::dropIfExists('reff_kategori_pajak');
        Schema::dropIfExists('reff_jenis_penetapan_pajak');
        Schema::dropIfExists('reff_jenis_pelaporan_pajak');
    }
}
