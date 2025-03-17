<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentSkillTable extends Migration
{
    public function up()
    {
        Schema::create('agent_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade');
            $table->string('emp_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agent_skill');
    }
}
