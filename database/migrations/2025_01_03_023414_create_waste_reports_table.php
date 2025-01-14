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
            $table->integer('estimated_weight')->comment('Berat dalam kg');
            $table->text('description')->nullable();
            $table->string('photo_path')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status', ['pending', 'verified', 'resolved'])->default('pending');
            $table->foreignUuid('verified_by')->nullable()->constrained('users');
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
