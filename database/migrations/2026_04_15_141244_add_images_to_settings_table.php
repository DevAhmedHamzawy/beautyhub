<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('logo')->after('address')->nullable();
            $table->string('favicon')->after('logo')->nullable();
            $table->string('footer_logo')->after('favicon')->nullable();
            $table->string('banner_one')->after('favicon')->nullable();
            $table->string('banner_two')->after('banner_one')->nullable();
            $table->string('banner_three')->after('banner_two')->nullable();
            $table->string('banner_four')->after('banner_three')->nullable();
            $table->string('banner_five')->after('banner_four')->nullable();
            $table->string('banner_six')->after('banner_five')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('logo');
            $table->dropColumn('favicon');
            $table->dropColumn('footer_logo');
            $table->dropColumn('banner_one');
            $table->dropColumn('banner_two');
            $table->dropColumn('banner_three');
            $table->dropColumn('banner_four');
            $table->dropColumn('banner_five');
            $table->dropColumn('banner_six');
        });
    }
};
