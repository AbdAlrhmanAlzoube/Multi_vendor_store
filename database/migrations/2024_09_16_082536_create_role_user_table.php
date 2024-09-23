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
        Schema::create('role_user', function (Blueprint $table) {  //create table use =>2 table user admin and user
            $table->morphs('authorizable'); //authorizable_type//authorizable_id
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();

            $table->unique(['authorizable_type','authorizable_id','role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
