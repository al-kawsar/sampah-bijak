<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('waste_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['TPS', 'TPA', 'TPS 3R', 'TPST']);
            $table->text('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->decimal('capacity', 10, 2);
            $table->string('contact_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_locations');
    }
};
