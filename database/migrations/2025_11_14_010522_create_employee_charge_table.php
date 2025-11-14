<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_charge', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('employee_id')->constrained('employee', 'id')->onDelete('cascade');
            $table->foreignUuid('charge_id')->constrained('charge', 'id')->onDelete('cascade');
            $table->string('area', 100);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('active')->default(true);
            $table->uuid('boss_id')->nullable();
            $table->timestamps();

            $table->unique(['employee_id', 'charge_id', 'active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_charge');
    }
};
