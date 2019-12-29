<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReffSatuanKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satker_adm_urusan', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('id');
            $table->string('nama');
            $table->boolean('status')->default(1);
            
            $table->timestamps();

            $table->primary(['id'], 'satker_adm_urusan_fk');
        });

        Schema::create('satker_adm_bidang', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('urusan_id');
            $table->unsignedInteger('id');
            $table->string('nama');
            $table->boolean('status')->default(1);
            
            $table->timestamps();

            $table->primary(['urusan_id', 'id'], 'satker_adm_bidang_fk');
            $table->index(['company_id', 'urusan_id', 'id']);

            $table->foreign(['urusan_id'], 'satker_adm_urusan_fk')
                ->references(['id'])
                ->on('satker_adm_urusan')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('satuan_adm_kerja', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('urusan_id');
            $table->unsignedInteger('bidang_id');
            $table->unsignedInteger('id');
            $table->string('nama');
            $table->boolean('status')->default(1);
            
            $table->timestamps();

            $table->primary(['urusan_id', 'bidang_id', 'id'], 'satuan_adm_kerja_fk');
            $table->index(['company_id', 'urusan_id', 'bidang_id', 'id']);

            $table->foreign(['urusan_id', 'bidang_id'], 'satker_adm_bidang_fk')
                ->references(['urusan_id', 'id'])
                ->on('satker_adm_bidang')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('satker_adm_upt', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('urusan_id');
            $table->unsignedInteger('bidang_id');
            $table->unsignedInteger('satker_id');
            $table->unsignedInteger('id');
            $table->string('nama');
            $table->boolean('status')->default(1);
            
            $table->timestamps();

            $table->primary(['urusan_id', 'bidang_id', 'satker_id', 'id'], 'satker_adm_upt_fk');
            $table->index(['company_id', 'urusan_id', 'bidang_id', 'satker_id', 'id']);

            $table->foreign(['urusan_id', 'bidang_id', 'satker_id'], 'satuan_adm_kerja_fk')
                ->references(['urusan_id', 'bidang_id', 'id'])
                ->on('satuan_adm_kerja')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('satker_upt');
        Schema::dropIfExists('satuan_kerja');
        Schema::dropIfExists('satker_adm_bidang');
        Schema::dropIfExists('satker_adm_urusan');
    }
}
