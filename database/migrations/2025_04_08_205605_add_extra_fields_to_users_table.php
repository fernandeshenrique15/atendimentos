<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf');
            $table->string('whatsapp');
            $table->string('commercial_address_street')->nullable();
            $table->string('commercial_address_number')->nullable();
            $table->string('commercial_address_neighborhood')->nullable();
            $table->string('commercial_address_city')->nullable();
            $table->string('commercial_address_zipcode')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('first_login')->default(true);
        });

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
            'cpf' => '12345678900',
            'whatsapp' => '1234567890',
            'commercial_address_street' => 'Rua Exemplo',
            'commercial_address_number' => '123',
            'commercial_address_neighborhood' => 'Centro',
            'commercial_address_city' => 'Cidade Exemplo',
            'commercial_address_zipcode' => '12345678',
            'is_admin' => true,
            'first_login' => true,
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
