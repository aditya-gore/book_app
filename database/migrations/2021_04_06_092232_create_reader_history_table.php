<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReaderHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('readerHistories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users')->nullable();
            $table->foreignId('bookId')->constrained('books')->nullable();
            $table->boolean('currently_Reading')->default(false);
            $table->timestamp('issuedAt')->nullable();
            $table->timestamp('finishedAt')->nullable();
            $table->boolean('wishlisted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('readerHistories');
    }
}
