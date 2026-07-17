<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('position')->default(0);
            $table->string('caption')->default('');
            // Bento spans, 1 or 2. Clamped to the column count at render time.
            $table->unsignedTinyInteger('col_span')->default(1);
            $table->unsignedTinyInteger('row_span')->default(1);
            $table->string('image_path')->nullable();
            $table->timestamps();

            $table->index('position');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
    }
};
