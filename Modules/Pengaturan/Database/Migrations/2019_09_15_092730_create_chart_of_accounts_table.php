<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChartOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akun_grup', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('id');
            $table->string('uuid', 36)->unique();
            $table->string('nama');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->primary(['company_id', 'id'], 'akun_grup_primary_key');
            $table->index(['company_id', 'id']);

            $table->foreign('company_id')->references('id')->on('companies')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('akun_kategori', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('grup_id');
            $table->unsignedInteger('id');
            $table->string('uuid', 36)->unique();
            $table->string('nama');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->primary(['company_id', 'grup_id', 'id'], 'akun_kategori_primary_key');
            $table->index(['company_id', 'grup_id', 'id']);

            $table->foreign(['company_id','grup_id'], 'akun_grup_fk')
                    ->references(['company_id','id'])
                    ->on('akun_grup')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        Schema::create('akun_subkategori', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('grup_id');
            $table->unsignedInteger('kategori_id');
            $table->unsignedInteger('id');
            $table->string('uuid', 36)->unique();
            $table->string('nama');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->primary(['company_id', 'grup_id', 'kategori_id', 'id'], 'akun_subkategori_primary_key');
            $table->index(['company_id', 'grup_id', 'kategori_id', 'id']);

            $table->foreign(['company_id','grup_id', 'kategori_id'], 'akun_kategori_fk')
                    ->references(['company_id', 'grup_id', 'id'])
                    ->on('akun_kategori')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        Schema::create('akun_subrekening', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('kategori_pajak_id');
            $table->unsignedInteger('grup_id');
            $table->unsignedInteger('kategori_id');
            $table->unsignedInteger('subkategori_id');
            $table->unsignedInteger('id');
            $table->string('uuid', 36)->unique();
            $table->string('nama');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->primary(['company_id', 'kategori_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'id'], 'akun_subrekening_primary_key');
            $table->index(['company_id', 'kategori_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'id']);

            $table->foreign(['kategori_pajak_id'], 'kategori_pajak_fk')
                    ->references(['id'])
                    ->on('reff_kategori_pajak');

            $table->foreign(['company_id', 'grup_id', 'kategori_id', 'subkategori_id'], 'akun_subkategori_fk')
                    ->references(['company_id', 'grup_id', 'kategori_id', 'id'])
                    ->on('akun_subkategori')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        Schema::create('akun_rekening', function (Blueprint $table) {
            $table->string('company_id')->unsigned();
            $table->unsignedInteger('kategori_pajak_id');
            $table->unsignedInteger('grup_id');
            $table->unsignedInteger('kategori_id');
            $table->unsignedInteger('subkategori_id');
            $table->unsignedInteger('subrekening_id');
            $table->unsignedInteger('id');
            $table->string('uuid', 36)->unique();
            $table->string('nama');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->primary(['company_id', 'kategori_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'subrekening_id', 'id'], 'akun_rekening_primary_key');
            $table->index(['company_id', 'kategori_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'subrekening_id', 'id']);

            $table->foreign(['company_id', 'kategori_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'subrekening_id'], 'akun_rekening_fk')
                ->references(['company_id', 'kategori_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'id'])
                ->on('akun_subrekening')
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
        // Schema::dropIfExists('akun_rekening');
        Schema::dropIfExists('akun_subrekening');
        Schema::dropIfExists('akun_subkategori');
        Schema::dropIfExists('akun_kategori');
        Schema::dropIfExists('akun_grup');
    }
}