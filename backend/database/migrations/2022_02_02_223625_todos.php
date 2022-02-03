<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Todos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('description', 1000)->nullable();
            $table->dateTime('deadline')->nullable();
            $table->string('origin', 100)->nullable();
            $table->string('ticket_id', 100)->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->string('scale', 100)->nullable();
            $table->string('status', 100)->nullable();
            $table->dateTime('completion')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
