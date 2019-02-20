<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->foreign()->references('id')->on('clients')
            ->ondelete('cascade')->onupdate('cascade');
            $table->integer('agent_id')->unsigned()->foreign()->references('user_id')->on('agents')
            ->ondelete('cascade')->onupdate('cascade');
            $table->integer('company_id')->unsigned()->foreign()->references('id')->on('companies')
            ->ondelete('cascade')->onupdate('cascade');
            $table->string('complaint');
            $table->string('action');
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
        Schema::dropIfExists('tickets');
    }
}
