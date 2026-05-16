<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tb_user') && Schema::hasColumn('tb_user', 'name')) {
            DB::statement('ALTER TABLE tb_user MODIFY name varchar(255) NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tb_user') && Schema::hasColumn('tb_user', 'name')) {
            DB::statement("UPDATE tb_user SET name = COALESCE(name, nama_lengkap, 'User')");
            DB::statement('ALTER TABLE tb_user MODIFY name varchar(255) NOT NULL');
        }
    }
};
