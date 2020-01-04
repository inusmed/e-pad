<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepegawaian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('urusan_id');
            $table->unsignedInteger('bidang_id');
            $table->unsignedInteger('satker_id');
            $table->string('uuid', 36);
            $table->string('nip', 50);
            $table->string('nama', 100);
            $table->string('username', 30)->nullable();
            $table->string('jabatan', 70)->nullable();
            $table->boolean('status')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign(['urusan_id', 'bidang_id', 'satker_id'], 'reff_satuan_kerja_fk')
                ->references(['urusan_id', 'bidang_id', 'id'])
                ->on('satuan_adm_kerja')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign(['uuid'], 'users_fk')
                ->references(['uuid'])
                ->on('users')
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
        Schema::dropIfExists('kepegawaian');
    }
}