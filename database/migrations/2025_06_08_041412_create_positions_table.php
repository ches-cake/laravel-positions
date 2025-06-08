<?php
// database/migrations/xxxx_xx_xx_create_positions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('position_name')->unique();
            $table->string('reports_to')->nullable(); // String as per your requirement
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('positions');
    }
};
