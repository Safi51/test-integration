<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->foreignId('api_service_id')
                ->nullable()
                ->constrained()
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->dropForeign('api_service_id');
            $table->dropColumn('api_service_id');
        });
    }
};
