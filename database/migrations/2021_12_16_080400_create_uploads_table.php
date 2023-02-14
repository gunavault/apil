<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('model');
            $table->string('filename');
            $table->integer('n_baris_excel')->comment('Jumlah ROW dalam excel yang diupload');
            $table->integer('tahun');
            $table->integer('bulan');
            $table->integer('tahun_bulan');
            $table->string('import_class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploads');
    }
}
