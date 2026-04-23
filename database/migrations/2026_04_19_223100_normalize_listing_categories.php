<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('categories')->updateOrInsert(
            ['slug' => 'new'],
            ['name' => 'Новые', 'description' => 'Новые автомобили без пробега']
        );

        DB::table('categories')->updateOrInsert(
            ['slug' => 'used'],
            ['name' => 'С пробегом', 'description' => 'Автомобили с пробегом']
        );

        $usedId = DB::table('categories')->where('slug', 'used')->value('id');

        if ($usedId) {
            DB::table('bbs')->whereNull('category_id')->update(['category_id' => $usedId]);
            DB::table('bbs')->whereNotIn('category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->whereIn('slug', ['new', 'used']);
            })->update(['category_id' => $usedId]);
        }
    }

    public function down(): void
    {
    }
};
