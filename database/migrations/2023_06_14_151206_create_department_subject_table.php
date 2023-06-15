<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('department_subject', function (Blueprint $table) {
            $table->increments('department_subject_id');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('subject_id');
            $table->string('level')->nullable();
            $table->enum('type', ['required', 'optional'])->nullable();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_subject');
    }
};
