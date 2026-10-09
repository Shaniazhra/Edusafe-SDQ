<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    if (!Schema::hasColumn('users', 'nis')) {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nis', 20)->nullable()->after('nip');
        });
    }

}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('nis');
    });
}
};
