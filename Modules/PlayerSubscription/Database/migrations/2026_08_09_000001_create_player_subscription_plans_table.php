<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_subscription_plans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('club_id')
                ->constrained('clubs')
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('billing_type', 20);

            $table->decimal('price', 10, 2);

            $table->unsignedInteger('duration_days')->nullable();

            $table->unsignedInteger('sessions_count')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['club_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_subscription_plans');
    }
};