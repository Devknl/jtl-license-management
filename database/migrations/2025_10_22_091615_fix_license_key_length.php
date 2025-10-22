<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixLicenseKeyLength extends Migration
{
    public function up()
    {
        Schema::table('licenses', function (Blueprint $table) {
            // Zuerst den Index entfernen falls er existiert
            $table->dropUnique(['license_key']);
            
            // Dann die Spaltenlänge ändern
            $table->string('license_key', 20)->change();
            
            // Und den Unique-Index wieder hinzufügen
            $table->unique('license_key');
        });
    }

    public function down()
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->dropUnique(['license_key']);
            $table->string('license_key')->change();
            $table->unique('license_key');
        });
    }
}