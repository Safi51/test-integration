<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')
                ->constrained()
                ->onDelete('restrict');
            $table->string('type_slug');
            $table->string('token')->nullable();
            $table->date('expires_at');

            $table->foreign('type_slug')
                ->on('token_types')
                ->references('slug')
                ->onDelete('restrict');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
