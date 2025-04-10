<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(new Expression('gen_random_uuid()'));
            $table->foreignId('user_id')->constrained()->index();
            $table->string('name');
            $table->string('cpf');
            $table->string('whatsapp');
            $table->string('email');
            $table->string('address_street')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_neighborhood')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_zipcode')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
        });

        Schema::create('service_types', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(new Expression('gen_random_uuid()'));
            $table->foreignId('user_id')->constrained()->index();
            $table->string('description');
            $table->decimal('default_price', 8, 2);
            $table->integer('default_duration');
            $table->timestamps();
        });

        Schema::create('expense_types', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(new Expression('gen_random_uuid()'));
            $table->foreignId('user_id')->constrained()->index();
            $table->string('description');
            $table->smallInteger('frequency')->comment('0: one-time, 1: monthly, 2: weekly, 3: daily');
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(new Expression('gen_random_uuid()'));
            $table->foreignId('user_id')->index();
            $table->foreignUuid('expense_type_id')->index();
            $table->string('description');
            $table->decimal('price', 8, 2);
            $table->date('date');
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(new Expression('gen_random_uuid()'));
            $table->timestamp('date');
            $table->integer('duration');
            $table->decimal('price', 8, 2);
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->integer('recurrence_count')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->index();
            $table->foreignUuid('service_type_id')->index();
            $table->foreignUuid('client_id')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_types');
        Schema::dropIfExists('service_types');
        Schema::dropIfExists('clients');
    }
};
