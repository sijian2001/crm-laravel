<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('first_name_kana');
            $table->string('last_name_kana');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('hire_date');
            $table->date('termination_date')->nullable();
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'temporary'])->default('full_time');
            $table->enum('position', ['manager', 'assistant_manager', 'supervisor', 'senior_staff', 'staff', 'trainee'])->default('staff');
            $table->decimal('salary', 10, 0)->nullable();
            $table->decimal('hourly_wage', 8, 0)->nullable();
            $table->string('department')->nullable();
            $table->enum('status', ['active', 'inactive', 'on_leave', 'terminated'])->default('active');
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();

            // インデックスの追加
            $table->index(['first_name', 'last_name']);
            $table->index(['position']);
            $table->index(['status']);
            $table->index(['store_id']);
            $table->index(['hire_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
