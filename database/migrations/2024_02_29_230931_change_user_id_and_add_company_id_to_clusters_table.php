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
        Schema::table('clusters', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->constrained('companies', 'id')->cascadeOnDelete();
            $table->dropForeign('clusters_user_id_foreign');
            $table->foreignId('user_id')->change()->nullable()->constrained('users', 'id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clusters', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
};
