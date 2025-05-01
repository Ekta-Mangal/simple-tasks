<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 2)->index('countries_country_code');
            $table->string('iso_code', 3);
            $table->string('isd_code', 10);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        // Insert data for the countries table
        $methods = [
            [
                'name' => 'India',
                'code' => 'IN',
                'iso_code' => 'IND',
                'isd_code' => '+91',
            ],
            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'iso_code' => 'GBR',
                'isd_code' => '+44',
            ],
            [
                'name' => 'United States',
                'code' => 'US',
                'iso_code' => 'USA',
                'isd_code' => '+1',
            ],
        ];

        DB::table('countries')->insert($methods);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
