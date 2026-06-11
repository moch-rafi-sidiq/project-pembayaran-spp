// database/migrations/2024_01_01_000004_create_spp_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spp', function (Blueprint $table) {
            $table->id();
            $table->string('tahun');
            $table->decimal('nominal', 15, 0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spp');
    }
};