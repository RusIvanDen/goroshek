<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_attributes_to_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributesToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->string('transmission_number')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('wheel_size')->nullable();
            $table->string('wheel_type')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('clearance')->nullable();
            $table->integer('wheelbase')->nullable();
            $table->string('color')->nullable();
        });
    }

    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn([
                'transmission_number',
                'fuel_type',
                'wheel_size',
                'wheel_type',
                'weight',
                'clearance',
                'wheelbase',
                'color'
            ]);
        });
    }
}
