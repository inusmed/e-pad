<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJenisPendapatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendapatan_pajak', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('kategori_pajak_id');
            $table->unsignedInteger('reff_pajak_id');
            $table->unsignedInteger('grup_id');
            $table->unsignedInteger('kategori_id');
            $table->unsignedInteger('subkategori_id');
            $table->unsignedInteger('subrekening_id');
            $table->unsignedInteger('rekening_id');
            $table->unsignedInteger('id')->length(2);
            $table->string('kode')->length(2);
            $table->string('kode_akun')->length(12);
            $table->string('uuid', 36);
            $table->string('nama');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->primary(['company_id', 'kategori_pajak_id', 'reff_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'subrekening_id', 'rekening_id', 'id'], 'pendapatan_pajak_pk');
            $table->unique(['company_id', 'kategori_pajak_id', 'reff_pajak_id', 'kode_akun', 'id']);
                
            $table->foreign(['reff_pajak_id'], 'reff_pajak_fk')
                ->references(['id'])
                ->on('reff_pajak')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign(['company_id', 'kategori_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'subrekening_id', 'rekening_id'], 'akun_rekening_fk')
                ->references(['company_id', 'kategori_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'subrekening_id', 'id'])
                ->on('akun_rekening')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('pendapatan_pajak_metadata', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('kategori_pajak_id');
            $table->unsignedInteger('reff_pajak_id');
            $table->unsignedInteger('grup_id');
            $table->unsignedInteger('kategori_id');
            $table->unsignedInteger('subkategori_id');
            $table->unsignedInteger('subrekening_id');
            $table->unsignedInteger('rekening_id');
            $table->unsignedInteger('id')->length(2);
            $table->string('kode_akun')->length(12);
            $table->unsignedInteger('reff_jenis_pajak_id');
            $table->unsignedInteger('reff_pelaporan_id');
            $table->unsignedInteger('reff_metode_hitung_id');
            $table->unsignedInteger('reff_penetapan_pajak_id');
            $table->integer('jatuh_tempo', false, false);
            $table->decimal('persentase', 5,2);
            $table->string('kode_akun_denda')->length(12);
            $table->timestamps();

            $table->primary(['company_id', 'kategori_pajak_id', 'reff_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'subrekening_id', 'rekening_id', 'id'], 'pendapatanmeta_pajak_pk');
            $table->unique(['company_id', 'kategori_pajak_id', 'reff_pajak_id', 'kode_akun', 'id']);

            $table->foreign(['reff_jenis_pajak_id'], 'reff_jenis_pajak_fk')
                ->references(['id'])
                ->on('reff_jenis_pajak')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->foreign(['reff_pelaporan_id'], 'reff_pelaporan_pajak_fk')
                ->references(['id'])
                ->on('reff_jenis_pelaporan_pajak')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign(['reff_metode_hitung_id'], 'reff_metode_hitung_pajak_fk')
                ->references(['id'])
                ->on('reff_metode_hitung_pajak')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign(['reff_penetapan_pajak_id'], 'reff_penetapan_pajak_fk')
                ->references(['id'])
                ->on('reff_jenis_penetapan_pajak')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign(['company_id', 'kategori_pajak_id', 'reff_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'subrekening_id', 'rekening_id', 'id'], 'pendapatan_pajak_fk')
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
        Schema::dropIfExists('pendapatan_pajak_metadata');
        Schema::dropIfExists('pendapatan_pajak');
    }
}