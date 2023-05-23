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
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->string('friendly_name');
            $table->string('key');
            $table->enum('type', ['text', 'integer', 'float', 'datetime', 'select', 'boolean']);
            $table->json('available_options');
            $table->boolean('required')->default(0);
            $table->string('default_value')->nullable();
            $table->text('description')->nullable();
            $table->string('model_class');
            $table->unsignedBigInteger('contextable_id')->nullable();
            $table->string('contextable_type')->nullable();
            $table->unique(['key', 'model_class', 'contextable_type', 'contextable_id']);
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
        Schema::dropIfExists('custom_fields');
    }
};
