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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();

            $table->string('code', 20)->unique();

            $table->string('name');

            $table->string('name_en')->nullable();

            $table->string('email')->nullable();

            $table->string('phone', 30)->nullable();

            $table->string('logo')->nullable();

            $table->text('address')->nullable();

            $table->string('club_status', 20)
                ->default('active')
                ->index();

            $table->string('subscription_status', 20)
                ->default('trial')
                ->index();

            $table->timestamps();

            $table->softDeletes();

            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
