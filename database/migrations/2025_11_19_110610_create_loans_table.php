<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('loans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // mahasiswa
        $table->foreignId('book_id')->constrained()->onDelete('cascade');
        $table->date('loan_date');
        $table->date('due_date');
        $table->date('return_date')->nullable();
        $table->decimal('fine_amount', 8, 2)->default(0);
        $table->enum('status', ['borrowed', 'returned', 'late'])->default('borrowed');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('loans');
}

};
