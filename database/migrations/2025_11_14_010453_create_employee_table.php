<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->string('lastname', 100);
            $table->string('identification', 20)->unique();
            $table->text('address');
            $table->string('phone', 20);
            $table->foreignUuid('birthplace_id')->constrained('city', 'id')->onDelete('cascade');
            $table->foreignUuid('country_id')->constrained('country', 'id')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
