<?php

use App\Models\User;
use App\Models\WasteCategory;
use App\Models\WasteLocation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('waste_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('location_id')->constrained('waste_locations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->constrained('waste_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('quantity');
            $table->text('description');
            $table->enum('status',['pending','verified','resolved']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_reports');
    }
};
