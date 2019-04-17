<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->foreign()->references('id')->on('users')
            ->ondelete('cascade')->onupdate('cascade');
            $table->integer('company_id')->unsigned()->foreign()->references('id')->on('companies')
            ->ondelete('cascade')->onupdate('cascade');
            $table->primary('user_id');
            $table->boolean('busy')->default(false);
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
        Schema::dropIfExists('agents');
    }
}
