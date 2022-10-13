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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('type')->default('inputs');
            $table->string('category')->default('general');
            $table->integer('quantity');
            $table->decimal('unit_cost', 10, 2);
            $table->string('manufacturer')->nullable();
            $table->string('distributor')->nullable();
            $table->foreignId('user_id')->onDelete('cascade')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
