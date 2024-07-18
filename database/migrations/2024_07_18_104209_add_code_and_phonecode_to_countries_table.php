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
        Schema::table('countries', function (Blueprint $table) {
            $table->string('code')->nullable()->after('name');
            $table->string('phonecode')->nullable()->after('code');
        });
    }
    
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('phonecode');
        });
    }
    
};
