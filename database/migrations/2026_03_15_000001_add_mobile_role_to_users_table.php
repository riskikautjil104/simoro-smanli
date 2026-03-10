<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // No migration needed as we just add 'mobile' to the role enum
        // This is just a marker that the mobile role exists
    }

    public function down(): void
    {
        //
    }
};

