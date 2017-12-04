<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtableConnection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('extable_connections', function(Blueprint $table)
		{
                    $table->bigincrements('id');
                    $table->integer('parent');
                    $table->integer('child');
                    $table->integer('module_id');                                   
                    $table->string('kolor_koszulki')->nullable();
                    $table->string('przekroj_przewodu')->nullable();
                    $table->string('kolor_przewodu')->nullable();
                    $table->string('zlacze');
                    $table->integer('dokladka');
                    $table->integer('blend');
                    $table->integer('active');
                    $table->integer('revision');
                    $table->integer('extratime');
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
        Schema::drop('extable_connections');
    }
}
