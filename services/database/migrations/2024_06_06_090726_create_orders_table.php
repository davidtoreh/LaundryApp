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

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->text('customer_address');
            $table->date('pickup_date')->nullable();
            $table->string('item_name');
            $table->integer('qty');
            $table->bigInteger('total_amount')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
