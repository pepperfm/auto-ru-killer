<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('autos', static function (Blueprint $table): void {
            $table->id();
            $table->boolean('is_new')->default(true);
            $table->string('brand');
            $table->string('model');
            $table->string('vin');
            $table->string('price');
            $table->string('year')->nullable();
            $table->string('mileage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autos');
    }
};
