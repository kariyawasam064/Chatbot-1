<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentTable extends Migration
{
    public function up()
    {
        Schema::create('agent', function (Blueprint $table) {
            $table->string('emp_id')->primary();
            $table->string('group_code');
            $table->timestamps();
            $table->foreign('group_code')->references('group_code')->on('group')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agent');
    }
}
