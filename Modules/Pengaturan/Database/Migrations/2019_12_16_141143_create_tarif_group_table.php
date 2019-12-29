<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarifGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reff_periode_tarif', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id')->unsigned();
            $table->string('nama');
            $table->boolean('status')->default(1);

            $table->timestamps();
        });

        Schema::create('tarif_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id')->unsigned();
            $table->string('nama');
            $table->boolean('status')->default(1);

            $table->timestamps();
        });

        Schema::create('tarif_omzet', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('kategori_pajak_id');
            $table->unsignedInteger('reff_pajak_id');
            $table->unsignedInteger('grup_id');
            $table->unsignedInteger('kategori_id');
            $table->unsignedInteger('subkategori_id');
            $table->unsignedInteger('subrekening_id');
            $table->unsignedInteger('rekening_id');
            $table->unsignedInteger('pendapatan_id')->length(2);
            $table->unsignedInteger('tarif_group_id');
            $table->integer('id', false, false);
            $table->string('kode_akun')->length(12);
            $table->unsignedInteger('reff_periode_tarif_id');
            $table->string('uuid', 36)->nullable();
            $table->string('nama', 100);
            $table->string('satuan', 50);
            $table->decimal('persentase', 5,2);
            $table->decimal('nilai', 18,0);
            $table->text('keterangan')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->primary(['company_id', 'kategori_pajak_id', 'reff_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'subrekening_id', 'rekening_id', 'pendapatan_id', 'id', 'tarif_group_id'], 'tarif_omzet_pajak_pk');
            $table->unique(['company_id', 'kategori_pajak_id', 'reff_pajak_id', 'kode_akun', 'id', 'tarif_group_id']);

            $table->foreign(['reff_periode_tarif_id'], 'reff_periode_tarif_fk')
                ->references(['id'])
                ->on('reff_periode_tarif')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                

            $table->foreign(['tarif_group_id'], 'tarif_group_fk')
                ->references(['id'])
                ->on('tarif_group')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign(['company_id', 'kategori_pajak_id', 'reff_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'subrekening_id', 'rekening_id', 'pendapatan_id'], 'jenis_pendapatan_fk')
                ->references(['company_id', 'kategori_pajak_id', 'reff_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'subrekening_id', 'rekening_id', 'id'])
                ->on('pendapatan_pajak')
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
        Schema::dropIfExists('tarif_omzet');
        Schema::dropIfExists('tarif_group');
        Schema::dropIfExists('reff_periode_tarif');
    }
}
