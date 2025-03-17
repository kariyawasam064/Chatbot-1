<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReporterGroupTable extends Migration
{
    public function up()
    {
        Schema::create('reporter_group', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->string('group_code');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('group_code')
                  ->references('group_code')->on('group')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reporter_group');
    }
}
