<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // column accept comany and compnay
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('job-seeker', 'compnay-owner', 'company-owner', 'admin')");

        // update exist date
        DB::table('users')
            ->where('role', 'compnay-owner')
            ->update(['role' => 'company-owner']);

        // column accept company only
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('job-seeker', 'company-owner', 'admin')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // عكس الخطوات في حال التراجع عن المايجريشن
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('job-seeker', 'compnay-owner', 'company-owner', 'admin')");

        DB::table('users')
            ->where('role', 'company-owner')
            ->update(['role' => 'compnay-owner']);

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('job-seeker', 'compnay-owner', 'admin')");
    }
};
