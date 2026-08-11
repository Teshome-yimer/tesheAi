<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Nullable and unique github id for users created via OAuth
            $table->string('github_id')->nullable()->unique()->after('id');
            // OAuth access token (nullable)
            $table->string('github_token')->nullable()->after('remember_token');
            // Profile avatar URL
            $table->string('avatar')->nullable()->after('github_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the unique index then the columns
            $table->dropUnique('users_github_id_unique');
            $table->dropColumn(['github_id', 'github_token', 'avatar']);
        });
    }
};
