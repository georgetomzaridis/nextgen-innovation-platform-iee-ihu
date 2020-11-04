<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreationCompTeamMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comp_join_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->nullable(false)->index();
            $table->unsignedBigInteger('admin_id')->nullable(false)->index();
            $table->unsignedBigInteger('member_id')->nullable(false)->index();
            $table->timestamps();
            $table->foreign('team_id')->references('id')->on('comp_join')->onDelete('cascade');
            $table->foreign('admin_id')->references('studentacc_id')->on('comp_join')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comp_join_members');
    }
}
