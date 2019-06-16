<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("offer_id")->unsigned()->index();
            $table->integer("offered_id")->unsigned()->index();
            $table->string("match")->nullable();
            $table->timestamps();
            
            $table->foreign("offer_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("offered_id")->references("id")->on("users")->onDelete("cascade");
        
            $table->unique(["offer_id", "offered_id"]);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
