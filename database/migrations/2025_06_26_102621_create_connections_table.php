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
        Schema::create('connections', function (Blueprint $table) {
            $table->id();

            // The user who initiated the connection request
            $table->foreignId('requester_id')->constrained('users')->onDelete('cascade');

            // The user who is receiving the connection request
            $table->foreignId('addressee_id')->constrained('users')->onDelete('cascade');

            // The status of the connection
            $table->enum('status', ['pending', 'accepted', 'declined', 'blocked'])->default('pending');

            $table->timestamps();

            // A user cannot send a request to the same person more than once.
            // This unique constraint ensures data integrity.
            $table->unique(['requester_id', 'addressee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connections');
    }
};
