<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateteachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_teachers', function (Blueprint $table) {
            $table->id('id_teachers');
            $table->string('nama_teachers');
            $table->string('city')->unique();
            $table->string('pob');
            $table->date('dob');
            $table->id('seubject_id');
            $table->timestamps();
        });

        DB::table('tb_teachers')->insert([
            'nama_teachers' => 'Kartika Nuraini',
            'city' => 'jakarta',
            'pob' => 'place of birth',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_teachers');
    }
}