<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNovaSettingsTable extends Migration
{
    public function up(): void
    {
        Schema::create('nova_settings', function (Blueprint $table) {
            $table->string('key')->unique()->primary();
            $table->text('value')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nova_settings');
    }
}
