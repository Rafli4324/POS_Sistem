<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('association_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antecedent_id')->constrained('menus')->onDelete('cascade');
            $table->foreignId('consequent_id')->constrained('menus')->onDelete('cascade');
            $table->float('support');
            $table->float('confidence');
            $table->float('lift');
            $table->timestamps();
            
            $table->index('antecedent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('association_rules');
    }
};
