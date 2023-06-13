<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->double('price');
            $table->integer('duration');
            $table->string('offer')->nullable();
            $table->double('offer_price')->nullable();
            $table->double('offer_discount')->nullable();
            $table->integer('offer_duration')->nullable();
            $table->date('offer_start_date')->nullable();
            $table->tinyinteger('offer_status')->default();
            $table->tinyInteger('status')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users', 'id');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id');
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
        Schema::dropIfExists('packages');
    }
};
