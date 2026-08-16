<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // صاحب الطلب (العميل)
        $table->foreignId('provider_id')->nullable()->constrained('users')->onDelete('set null'); // المقدم للخدمة (اختياري)
$table->foreignId('post_id')->nullable()->constrained('post')->onDelete('set null');        $table->string('title');
        $table->text('description')->nullable();
        $table->string('location')->nullable();
        $table->decimal('price', 10, 2)->nullable();
        $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
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
