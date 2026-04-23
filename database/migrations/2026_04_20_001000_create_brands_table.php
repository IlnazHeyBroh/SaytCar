<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        $now = now();
        $brands = [
            'Audi',
            'BMW',
            'Mercedes-Benz',
            'Toyota',
            'Lexus',
            'Ford',
            'Volkswagen',
            'Hyundai',
            'Nissan',
            'Porsche',
            'Jeep',
            'Tesla',
            'Honda',
            'Kia',
            'Mazda',
            'Skoda',
            'Renault',
            'Peugeot',
            'Bentley',
            'Infiniti',
            'Subaru',
            'Volvo',
            'Jaguar',
            'Land Rover',
            'Chevrolet',
            'Dodge',
            'Cadillac',
            'Acura',
            'Genesis',
        ];

        $rows = [];
        foreach ($brands as $brand) {
            $rows[] = [
                'name' => $brand,
                'slug' => \Illuminate\Support\Str::slug($brand),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('brands')->insert($rows);
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
