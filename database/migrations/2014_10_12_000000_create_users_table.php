<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('email', 128)->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 128)->nullable();
            $table->enum('active', ['yes', 'no'])->default('yes');
            /* Role is for switch panel in routes, the default, below 'admin'. */
            $table->enum('role', ['admin'])->default('admin');
            $table->string('last_access_agent', 255)->nullable();
            $table->string('last_access_ip', 32)->nullable();
            $table->timestamp('last_access_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        $user = DB::table('users');
        $user->insert([
            'name' => 'User',
            'email' => 'user@test.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('user'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
