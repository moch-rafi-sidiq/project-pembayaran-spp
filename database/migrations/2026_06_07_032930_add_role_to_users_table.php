// database/migrations/2024_01_01_000001_add_role_to_users_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nis')->unique()->nullable()->after('id');
            $table->string('no_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('role', ['admin', 'bendahara', 'siswa'])->default('siswa');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->boolean('status_aktif')->default(true);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nis', 'no_telepon', 'alamat', 'role', 'jenis_kelamin', 'status_aktif']);
        });
    }
};