<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('opening_hours')->nullable();
            $table->string('closed_days')->nullable();
            $table->enum('status', ['open', 'closed', 'preparing'])->default('preparing');
            $table->string('manager_name')->nullable();
            $table->date('opening_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            // インデックスの追加
            $table->index(['name']);
            $table->index(['status']);
            $table->index(['opening_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
