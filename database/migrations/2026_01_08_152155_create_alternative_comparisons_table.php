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
    Schema::create('alternative_comparisons', function (Blueprint $table) {
      $table->id();
      $table->foreignId('criterion_id')->constrained('criterias')->cascadeOnDelete();
      $table->foreignId('alternative_id_1')->constrained('alternatives')->cascadeOnDelete();
      $table->foreignId('alternative_id_2')->constrained('alternatives')->cascadeOnDelete();
      $table->decimal('value', 8, 4);
      $table->softDeletes();
      $table->timestamps();
      $table->unique(['criterion_id', 'alternative_id_1', 'alternative_id_2'], 'unique_alternative_comparisons');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('alternative_comparisons');
  }
};
