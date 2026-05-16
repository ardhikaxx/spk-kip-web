<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && ! Schema::hasTable('tb_user')) {
            Schema::rename('users', 'tb_user');
        }

        if (! Schema::hasTable('tb_user')) {
            return;
        }

        Schema::table('tb_user', function (Blueprint $table): void {
            if (Schema::hasColumn('tb_user', 'id') && ! Schema::hasColumn('tb_user', 'id_user')) {
                $table->renameColumn('id', 'id_user');
            }
        });

        Schema::table('tb_user', function (Blueprint $table): void {
            if (! Schema::hasColumn('tb_user', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable()->after('id_user');
            }
            if (! Schema::hasColumn('tb_user', 'nomor_telepon')) {
                $table->string('nomor_telepon')->nullable()->after('email');
            }
            if (! Schema::hasColumn('tb_user', 'role')) {
                $table->enum('role', ['admin', 'kaprodi'])->default('kaprodi')->after('nomor_telepon');
            }
        });

        if (Schema::hasColumn('tb_user', 'name') && Schema::hasColumn('tb_user', 'nama_lengkap')) {
            DB::table('tb_user')
                ->whereNull('nama_lengkap')
                ->update(['nama_lengkap' => DB::raw('name')]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tb_user') && ! Schema::hasTable('users')) {
            Schema::rename('tb_user', 'users');
        }
    }
};
