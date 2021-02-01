<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnWargaAnak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->date('tanggal_menetap')->nullable();
            $table->string('no_skwb',50)->nullable();
            $table->string('status_perkawinan',20)->nullable();
            $table->string('agama',10)->nullable();
            $table->string('tempat_lahir',25)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('jalan_blok')->nullable();
            $table->string('kelurahan_id',50)->nullable();
            $table->string('kecamatan_id',50)->nullable();
            $table->string('kota_kabupaten',50)->nullable();
            $table->string('pasangan_hubungan',25)->nullable();
            $table->string('pasangan_nama',25)->nullable();
            $table->string('pasangan_tempat_lahir',25)->nullable();
            $table->date('pasangan_tanggal_lahir')->nullable();
            $table->string('pasangan_nik',50)->nullable();
            $table->string('pasangan_no_hp',25)->nullable();

            $table->string('anak_1_nama',35)->nullable();
            $table->string('anak_1_tempat_lahir',25)->nullable();
            $table->date('anak_1_tanggal_lahir')->nullable();
            $table->string('anak_1_nik_kia',35)->nullable();
            $table->string('anak_1_jenis_kelamin',35)->nullable();

            $table->string('anak_2_nama',35)->nullable();
            $table->string('anak_2_tempat_lahir',25)->nullable();
            $table->date('anak_2_tanggal_lahir')->nullable();
            $table->string('anak_2_nik_kia',35)->nullable();
            $table->string('anak_2_jenis_kelamin',35)->nullable();

            $table->string('anak_3_nama',35)->nullable();
            $table->string('anak_3_tempat_lahir',25)->nullable();
            $table->date('anak_3_tanggal_lahir')->nullable();
            $table->string('anak_3_nik_kia',35)->nullable();
            $table->string('anak_3_jenis_kelamin',35)->nullable();

            $table->string('anak_4_nama',35)->nullable();
            $table->string('anak_4_tempat_lahir',25)->nullable();
            $table->date('anak_4_tanggal_lahir')->nullable();
            $table->string('anak_4_nik_kia',35)->nullable();
            $table->string('anak_4_jenis_kelamin',35)->nullable();

            $table->string('anak_5_nama',35)->nullable();
            $table->string('anak_5_tempat_lahir',25)->nullable();
            $table->date('anak_5_tanggal_lahir')->nullable();
            $table->string('anak_5_nik_kia',35)->nullable();
            $table->string('anak_5_jenis_kelamin',35)->nullable();

            $table->string('lain_1_nama',35)->nullable();
            $table->string('lain_1_tempat_lahir',25)->nullable();
            $table->date('lain_1_tanggal_lahir')->nullable();
            $table->string('lain_1_nik_kia',35)->nullable();
            $table->string('lain_1_no_hp',35)->nullable();
            $table->string('lain_1_jenis_kelamin',35)->nullable();

            $table->string('lain_2_nama',35)->nullable();
            $table->string('lain_2_tempat_lahir',25)->nullable();
            $table->date('lain_2_tanggal_lahir')->nullable();
            $table->string('lain_2_nik_kia',35)->nullable();
            $table->string('lain_2_no_hp',35)->nullable();
            $table->string('lain_2_jenis_kelamin',35)->nullable();
            $table->string('jenis_kelamin',20)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warga', function (Blueprint $table) {
            //
        });
    }
}
