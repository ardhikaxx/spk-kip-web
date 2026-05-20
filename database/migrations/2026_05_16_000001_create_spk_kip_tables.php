<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // User & Auth Tables
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('nomor_telepon')->nullable();
            $table->enum('role', ['admin', 'kaprodi'])->default('kaprodi');
            $table->string('prodi')->nullable();
            $table->string('jurusan')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // SPK KIP Tables
        Schema::create('tb_mahasiswa', function (Blueprint $table) {
            $table->string('nim')->primary();
            $table->string('nama_mhs');
            $table->string('prodi')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('kip')->nullable();
            $table->string('dtk')->nullable();
            $table->integer('desil')->nullable();
            $table->string('kerja_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            $table->string('keterangan_ayah')->nullable();
            $table->string('kerja_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            $table->string('keterangan_ibu')->nullable();
            $table->string('prestasi')->nullable();
            $table->timestamps();
        });

        Schema::create('tb_kriteria', function (Blueprint $table) {
            $table->id('id_kriteria');
            $table->string('kode_kriteria', 10)->unique();
            $table->string('nama_kriteria');
            $table->enum('jenis_kriteria', ['benefit', 'cost'])->default('benefit');
            $table->decimal('nilai_bobot', 8, 4)->default(0);
            $table->timestamps();
        });

        Schema::create('tb_sub_kriteria', function (Blueprint $table) {
            $table->id('id_subkriteria');
            $table->foreignId('id_kriteria')->constrained('tb_kriteria', 'id_kriteria')->cascadeOnDelete();
            $table->string('nama_subkriteria');
            $table->integer('nilai')->default(1);
            $table->timestamps();
        });

        Schema::create('tb_bobot', function (Blueprint $table) {
            $table->id('id_bobot');
            $table->foreignId('id_kriteria')->unique()->constrained('tb_kriteria', 'id_kriteria')->cascadeOnDelete();
            $table->decimal('nilai_bobot', 8, 4)->default(0);
            $table->timestamps();
        });

        Schema::create('tb_alternatif', function (Blueprint $table) {
            $table->id('id_alternatif');
            $table->string('nim');
            $table->year('tahun');
            foreach (range(1, 6) as $i) {
                $table->integer("c{$i}")->default(1);
                $table->string("label_c{$i}")->nullable();
            }
            $table->timestamps();
            $table->foreign('nim')->references('nim')->on('tb_mahasiswa')->cascadeOnDelete();
            $table->unique(['nim', 'tahun']);
        });

        Schema::create('tb_hasil_perhitungan', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->foreignId('id_alternatif')->constrained('tb_alternatif', 'id_alternatif')->cascadeOnDelete();
            $table->decimal('leaving_flow', 12, 8)->default(0);
            $table->decimal('entering_flow', 12, 8)->default(0);
            $table->decimal('net_flow', 12, 8)->default(0);
            $table->integer('ranking');
            $table->string('status')->default('Tidak Penerima');
            $table->year('tahun');
            $table->timestamps();
            $table->unique(['id_alternatif', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_hasil_perhitungan');
        Schema::dropIfExists('tb_alternatif');
        Schema::dropIfExists('tb_bobot');
        Schema::dropIfExists('tb_sub_kriteria');
        Schema::dropIfExists('tb_kriteria');
        Schema::dropIfExists('tb_mahasiswa');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('tb_user');
    }
};
