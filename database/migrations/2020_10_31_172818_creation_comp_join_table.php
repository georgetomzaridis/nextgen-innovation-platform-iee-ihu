<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreationCompJoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comp_join', function (Blueprint $table) {
            $table->id();
            $table->string('studentacc_id', 240)->index()->nullable(false);
            $table->string('submision_id', 240)->unique()->index()->nullable(false);
            $table->string('teamname', 100)->index()->unique()->nullable(false);
            $table->string('appname', 100)->index()->unique()->nullable(false);
            $table->string('apptags', 200)->index()->nullable(false);
            $table->Text('appdesc')->nullable(false);
            $table->integer('join_type')->nullable(false)->default(1);
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
        Schema::dropIfExists('comp_join');
    }
}
