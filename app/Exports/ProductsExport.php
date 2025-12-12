<?php

namespace App\Exports;

use App\Models\Product;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {

        // Повертаємо масив зі заголовками для колонок Excel-файлу
        return [

            'Name',
            'Article',
            'Price',
            'Old Price',
            'Attribute',
            'Brand',
            'Category',
            'Image',
            'Description',

            // Додайте інші необхідні колонки
        ];
    }
    public function map($product): array
    {
        $property = $product->properties->first();
        $category =$product->categories;
        $attribut = $property ? $property->attribute->name : '';
        $mediaFiles = $product->getMedia('product_photo');
        $imageUrls = [];
        $attributAndValue = $attribut ? "$attribut: " . ($property ? $property->value : '') : '';
        foreach ($mediaFiles as $media) {
            // Додайте URL фото до масиву
            $imageUrls[] = $media->getUrl();
        }

        // Об'єднайте URL фото в одну рядок (розділити комами або іншим роздільником, якщо потрібно)
        $image = implode(', ', $imageUrls);
        return [
            $product->name,
            $product->article,
            $product->price,
            $product->old_price,
            $attributAndValue,
            $product->brand,
            $category ? $category->name : '',
            $image,
            $product->description,
            // Отримуємо значення атрибуту або залишаємо порожнє значення, якщо відношення порожнє або відсутнє значення 'values'
            // Припускаючи, що це поле містить URL або інші дані про фото
        ];
    }
}
