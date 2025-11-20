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
        Schema::table('betta_fish', function (Blueprint $table) {
            if (!Schema::hasColumn('betta_fish', 'description')) {
                $table->text('description')->nullable()->after('stock');
            }
            if (!Schema::hasColumn('betta_fish', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('betta_fish', function (Blueprint $table) {
            if (Schema::hasColumn('betta_fish', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('betta_fish', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
