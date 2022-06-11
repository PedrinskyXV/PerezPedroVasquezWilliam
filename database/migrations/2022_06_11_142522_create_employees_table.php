<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->integer('age', 2);
            $table->decimal('salary_base', 6,2);
            $table->string('address',150);
            $table->string('photo')->nullable();
            $table->integer('id_administrador')->unsigned();
            $table->foreign('id_administrador')->references('id')->on('users')->onUpdate('cascade');
            $table->integer('id_branch')->unsigned();
            $table->foreign('id_branch')->references('id')->on('branches')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
