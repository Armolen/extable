<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtableRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('extable_revisions', function(Blueprint $table)
		{
                    $table->bigincrements('id');
                    $table->integer('oldconnection_id');
                    $table->integer('newconnection_id');
                    $table->integer('code');                               
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
        Schema::drop('extable_revisions');
    }
}
