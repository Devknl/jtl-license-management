<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLicenseKeyLength extends Migration
{
    public function up()
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->string('license_key', 20)->unique()->change();
        });
    }

    public function down()
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->string('license_key')->unique()->change();
        });
    }
}