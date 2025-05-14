<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('leave_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained()->onDelete('cascade');
        $table->unsignedBigInteger('leave_type_id');
        $table->foreignId('leave_type_id')->constrained()->onDelete('cascade');
        $table->date('from_date');
        $table->date('to_date');
        $table->text('reason')->nullable();
        $table->text('notes')->nullable();
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->timestamps();

    });
}

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
