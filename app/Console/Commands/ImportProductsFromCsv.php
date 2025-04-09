<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportProductsFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from CSV';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('app/products.csv');

        if (!file_exists($filePath)) {
            $this->error('The file is not found on the path: ' . $filePath);
            return;
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            $this->error('The file can\'t be opened.');
            return;
        }

        $header = fgetcsv($handle, 0, ',');
        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            [$name, $price, $cat1, $cat2, $cat3] = array_pad($row, 5, null);

            if (!$name || !$price) continue;

            // Create or update product
            $product = \App\Models\Product::updateOrCreate(
                ['name' => $name],
                ['price' => (int)$price]
            );

            // Sync categories
            $categoryNames = collect([$cat1, $cat2, $cat3])
                ->filter()
                ->unique();

            $categoryIds = $categoryNames->map(function ($catName) {
                return \App\Models\Category::firstOrCreate(['name' => $catName])->id;
            });

            $product->categories()->sync($categoryIds);
        }

        fclose($handle);

        $this->info('The file is imported successfully.');
    }
}
