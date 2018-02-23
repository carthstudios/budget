<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = [];

        // Positives
        $seeds[] = ['is_positive' => true,  'name' => "Regular salaries"];
        $seeds[] = ['is_positive' => true,  'name' => "Small sales"];
        $seeds[] = ['is_positive' => true,  'name' => "Gifts"];
        $seeds[] = ['is_positive' => true,  'name' => "Financial investments"];

        // Negatives
        $seeds[] = ['is_positive' => false, 'name' => "Food groceries"];
        $seeds[] = ['is_positive' => false, 'name' => "Restaurants"];
        $seeds[] = ['is_positive' => false, 'name' => "Health insurance monthly"];
        $seeds[] = ['is_positive' => false, 'name' => "Health costs"];
        $seeds[] = ['is_positive' => false, 'name' => "Car related (incl. parking)"];
        $seeds[] = ['is_positive' => false, 'name' => "Transportations (no car)"];

        foreach($seeds as $seed)
        {
            $seed['created_at'] = $seed['updated_at'] = \Illuminate\Support\Carbon::now()->format('Y-m-d H:i:s');
            DB::table('categories')->insert($seed);
        }
    }
}
