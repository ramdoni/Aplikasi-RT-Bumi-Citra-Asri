<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama',255)->nullable();
            $table->string('no_telepon',50)->nullable();
            $table->string('nik',255)->nullable();
            $table->string('no_kk',255)->nullable();
            $table->timestamps();
        });

        Schema::create('warga_keluarga', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('warga_id')->nullable();
            $table->string('nama',150)->nullable();
            $table->string('hubungan',50)->nullable();
            $table->string('nik',200)->nullable();
            $table->string('jenis_kelamin',10)->nullable();
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
        Schema::dropIfExists('warga');
    }
}
