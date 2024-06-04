<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropForeign(['client_id']);
        });
    
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreign('profile_id')
                  ->references('id')->on('profiles')
                  ->onDelete('cascade');
            
            $table->foreign('client_id')
                  ->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropForeign(['client_id']);
        });
    
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreign('profile_id')->references('id')->on('profiles');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }
};
