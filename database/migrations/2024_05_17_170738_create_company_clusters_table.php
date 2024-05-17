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
        Schema::create('company_clusters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cluster_id')->constrained('clusters', 'id');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->boolean('is_redactor')->default(false);
            $table->boolean('is_reader')->default(false);
            $table->boolean('is_inviter')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_clusters');
    }
};
