# Product Importer and XML Feed Generator

This is a simple tool to import products with prices and categories into MySQL and export them as an XML feed.

## Features

- **Import Products from CSV**
- **Export Products as XML Feed**

## Import Products from CSV

To import products, follow these steps:

1. **CSV File Placement:**
   - Place the CSV file into the `storage/app` folder.
   - The CSV file must be named `products.csv` and should be comma-separated.

2. **Import Command:**
   - Run the following command to import the products:
     ```bash
     php artisan import:products
     ```

3. **Import Details:**
   - Products with their prices are imported into the `products` table.
   - Categories are imported into the `categories` table.
   - Relations between products and categories are stored in the `category_product` table.
   - If a product or category doesn't exist, it will be created.
   - If a product exists, its price and categories will be updated.

## Export Products as XML Feed

To export the products as an XML feed:

1. **Export Command:**
   - Run the following command to generate the XML feed:
     ```bash
     php artisan feed:generate
     ```

2. **Export Details:**
   - The generated XML file will be named `product_feed.xml` and saved in the `storage/app` folder.

3. **XML Format:**
   The exported XML will follow this format:
   ```xml
   <?xml version="1.0" encoding="UTF-8"?>
   <products>
       <product>
           <title>Name of the product</title>
           <price>1990</price>
           <categories>
               <category>Winter clothes</category>
               <category>Summer clothes</category>
           </categories>
       </product>
       <product>
           <title>Name of the product</title>
           <price>125</price>
           <categories>
               <category>Winter clothes</category>
           </categories>
       </product>
       <!-- ... -->
   </products>
   ```




The solution of task 2 is in the file root/task-2-SQL-query.sql