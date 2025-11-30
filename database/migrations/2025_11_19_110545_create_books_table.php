<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up()
{
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('author');
        $table->string('publisher');
        $table->year('publication_year');
        $table->string('category');
        $table->integer('stock')->default(0);
        $table->integer('max_loan_days');
        $table->decimal('fine_per_day', 8, 2);
        $table->string('status')->default('available');  
        $table->text('description')->nullable();
        $table->decimal('rating', 3, 2)->default(0);
        $table->timestamps();
    });
}


public function down()
{
    Schema::dropIfExists('books');
}

};
