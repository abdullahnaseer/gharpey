<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SoftDeleteUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('services', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('service_seller', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('sellers', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('buyers', function (Blueprint $table) {
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('services', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('service_seller', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('buyers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
