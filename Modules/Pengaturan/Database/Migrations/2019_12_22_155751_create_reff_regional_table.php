<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReffRegionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reff_wilayah_propinsi', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('id');
            $table->string('nama');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->primary(['id'], 'reff_wilayah_propinsi_pk');
            $table->index(['company_id', 'id']);
        });

        Schema::create('reff_wilayah_kabupaten', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('propinsi_id');
            $table->unsignedInteger('id');
            $table->string('nama');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->primary(['propinsi_id', 'id'], 'reff_wilayah_kabupaten_pk');
            $table->index(['company_id', 'propinsi_id', 'id']);

            $table->foreign(['propinsi_id'], 'reff_wilayah_propinsi_fk')
                ->references(['id'])
                ->on('reff_wilayah_propinsi')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('reff_wilayah_kecamatan', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('propinsi_id');
            $table->unsignedInteger('kabupaten_id');
            $table->unsignedInteger('id');
            $table->string('nama');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->primary(['propinsi_id', 'kabupaten_id', 'id'], 'reff_wilayah_kecamatan_pk');
            $table->index(['company_id', 'propinsi_id', 'kabupaten_id', 'id']);

            $table->foreign(['propinsi_id', 'kabupaten_id'], 'reff_wilayah_kabupaten_fk')
                ->references(['propinsi_id', 'id'])
                ->on('reff_wilayah_kabupaten')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('reff_wilayah_kelurahan', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('propinsi_id');
            $table->unsignedInteger('kabupaten_id');
            $table->unsignedInteger('kecamatan_id');
            $table->unsignedInteger('id');
            $table->string('nama');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->primary(['propinsi_id', 'kabupaten_id', 'kecamatan_id', 'id'], 'reff_wilayah_kelurahan_pk');
            $table->index(['company_id', 'propinsi_id', 'kabupaten_id', 'kecamatan_id', 'id']);

            $table->foreign(['propinsi_id', 'kabupaten_id', 'kecamatan_id'], 'reff_wilayah_kecamatan_fk')
                ->references(['propinsi_id', 'kabupaten_id', 'id'])
                ->on('reff_wilayah_kecamatan')
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
        Schema::dropIfExists('reff_wilayah_kelurahan');
        Schema::dropIfExists('reff_wilayah_kecamatan');
        Schema::dropIfExists('reff_wilayah_kabupaten');
        Schema::dropIfExists('reff_wilayah_propinsi');
    }
}
