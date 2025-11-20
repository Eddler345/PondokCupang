<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });

        // seed default home page row
        DB::table('pages')->insert([
            'key' => 'home',
            'title' => 'Selamat Datang di Sistem Pemesanan Ikan Cupang',
            'content' => 'Temukan berbagai jenis ikan cupang berkualitas tinggi langsung dari breeder terbaik.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
