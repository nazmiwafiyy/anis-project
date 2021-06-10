<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('position_id');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('type_id');
            $table->string('fullname');
            $table->string('identity_no')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('notes')->nullable();
            $table->integer('attemp')->nullable();
            $table->string('relationship')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('position_id');
            $table->index('department_id');
            $table->index('type_id');

            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('cascade');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
