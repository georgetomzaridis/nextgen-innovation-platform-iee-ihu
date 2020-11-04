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
        Schema::enableForeignKeyConstraints();
        Schema::create('comp_join', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('studentacc_id')->index();
            $table->string('submision_id', 240)->unique()->nullable(false);
            $table->string('invite_code', 240)->unique()->nullable(true);
            $table->integer('invite_active')->nullable(false)->default(1);
            $table->string('teamname', 100)->unique()->nullable(false);
            $table->string('appname', 100)->unique()->nullable(false);
            $table->string('apptags', 200)->nullable(false);
            $table->Text('appdesc')->nullable(false);
            $table->integer('join_type')->nullable(false)->default(1);
            $table->timestamps();
            $table->foreign('studentacc_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('studentacc_id')->references('team_id')->on('comp_team_members');
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
