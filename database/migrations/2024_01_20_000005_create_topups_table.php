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
        Schema::create('topups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "86 Diamonds", "100 UC"
            $table->string('currency_name'); // e.g., "Diamonds", "UC", "Genesis Crystals"
            $table->string('currency_icon')->nullable(); // Icon for the currency
            $table->integer('amount'); // Amount of currency
            $table->integer('bonus_amount')->default(0); // Bonus amount
            $table->decimal('price', 12, 2);
            $table->decimal('original_price', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('topup_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('topup_id')->constrained()->onDelete('cascade');
            $table->string('game_id'); // Player ID in game
            $table->string('game_server')->nullable(); // Server ID if needed
            $table->string('game_nickname')->nullable(); // Nickname for verification
            $table->decimal('total_price', 12, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('payment_proof')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topup_orders');
        Schema::dropIfExists('topups');
    }
};
