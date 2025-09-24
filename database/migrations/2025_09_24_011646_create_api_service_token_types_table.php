<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_service_token_types', function (Blueprint $table) {
            $table->id();
            $table->string('token_type_slug');
            $table->foreignId('api_service_id')
                ->constrained()
                ->onDelete('restrict');

            $table->foreign('token_type_slug')
                ->on('token_types')
                ->references('slug')
                ->onDelete('restrict');

            $table->unique(['api_service_id', 'token_type_slug']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_service_token_types');
    }
};
