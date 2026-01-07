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
    Schema::create('criterion_comparisons', function (Blueprint $table) {
      $table->id();
      $table->foreignId('criterion_id_1')->constrained('criterias')->cascadeOnDelete();
      $table->foreignId('criterion_id_2')->constrained('criterias')->cascadeOnDelete();
      $table->decimal('value', 8, 4);
      $table->softDeletes();
      $table->timestamps();
      $table->unique(['criterion_id_1', 'criterion_id_2'], 'unique_comparison');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('criterion_comparisons');
  }
};
