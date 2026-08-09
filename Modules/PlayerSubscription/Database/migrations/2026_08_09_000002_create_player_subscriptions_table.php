<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('club_id')
                ->constrained('clubs')
                ->cascadeOnDelete();

            $table->foreignId('player_id')
                ->constrained('players')
                ->cascadeOnDelete();

            $table->foreignId('player_subscription_plan_id')
                ->constrained('player_subscription_plans')
                ->restrictOnDelete();

            $table->decimal('price_before_discount', 10, 2);

            $table->string('discount_type', 20)->nullable();

            $table->decimal('discount_value', 10, 2)->nullable();

            $table->string('discount_reason')->nullable();

            $table->decimal('final_price', 10, 2);

            $table->date('starts_at');

            $table->date('ends_at')->nullable();

            $table->unsignedInteger('sessions_remaining')->nullable();

            $table->string('status', 20)->default('active');

            $table->timestamps();

            $table->index(['club_id', 'status']);
            $table->index(['player_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_subscriptions');
    }
};