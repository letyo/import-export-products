<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class GenerateProductFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate XML feed of products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::with('categories')->get();

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><products></products>');

        foreach ($products as $product) {
            $productXml = $xml->addChild('product');
            $productXml->addChild('title', htmlspecialchars($product->name));
            $productXml->addChild('price', $product->price);

            $categoriesXml = $productXml->addChild('categories');
            foreach ($product->categories as $category) {
                $categoriesXml->addChild('category', htmlspecialchars($category->name));
            }
        }

        file_put_contents(storage_path('app/product_feed.xml'), $xml->asXML());

        $this->info('XML feed is generated: storage/app/product_feed.xml');
    }
}
