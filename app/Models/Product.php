<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'product';
    protected $guarded = ['id'];

    public static function related() {

        $products = [
            [
                'id' => 'bhc',
                'name' => 'BHC',
                'image' => asset('products/BHC.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'borvelar',
                'name' => '3x Borvélar',
                'image' => asset('products/borvélar.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'conturo',
                'name' => 'Conturo',
                'image' => asset('products/conturo.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'ryksuga-ct-17',
                'name' => 'Ryksuga CT-17',
                'image' => asset('products/CT17.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'ryksuga-ctl26e',
                'name' => 'Ryksuga CTL26E',
                'image' => asset('products/CTL26E.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'skrufuvel-cxs',
                'name' => 'Skrúfuvél CXS',
                'image' => asset('products/CXS.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'dwc',
                'name' => 'Negla DWC',
                'image' => asset('products/DWC.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'handfraesari-xt-9',
                'name' => 'Handfræsari XT-9',
                'image' => asset('products/handfræsarar.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'midi-ryksuga',
                'name' => 'Ryksuga MIDI',
                'image' => asset('products/MIDI.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'handsog-OF1400',
                'name' => 'Handsög OF1400',
                'image' => asset('products/OF1400.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'handsog-OF1400-med-ryksugu',
                'name' => 'Handsög OF1400 + Ryksuga',
                'image' => asset('products/OF1400+ryksuga.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'handsog-sett',
                'name' => 'Handsögs sett',
                'image' => asset('products/OF1400LAND.jpg'),
                'manufacturer' => 'Festool'
            ]
        ];

        $random = array_rand($products, 3);

        return [
                $products[$random[0]],
                $products[$random[1]],
                $products[$random[2]]
        ];

    }

    public static function all( $id = null ) {

        $products = [
            [
                'id' => 'bhc',
                'name' => 'BHC',
                'image' => asset('products/BHC.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'borvelar',
                'name' => '3x Borvélar',
                'image' => asset('products/borvélar.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'conturo',
                'name' => 'Conturo',
                'image' => asset('products/conturo.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'ryksuga-ct-17',
                'name' => 'Ryksuga CT-17',
                'image' => asset('products/CT17.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'ryksuga-ctl26e',
                'name' => 'Ryksuga CTL26E',
                'image' => asset('products/CTL26E.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'skrufuvel-cxs',
                'name' => 'Skrúfuvél CXS',
                'image' => asset('products/CXS.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'dwc',
                'name' => 'Negla DWC',
                'image' => asset('products/DWC.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'handfraesari-xt-9',
                'name' => 'Handfræsari XT-9',
                'image' => asset('products/handfræsarar.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'midi-ryksuga',
                'name' => 'Ryksuga MIDI',
                'image' => asset('products/MIDI.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'handsog-OF1400',
                'name' => 'Handsög OF1400',
                'image' => asset('products/OF1400.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'handsog-OF1400-med-ryksugu',
                'name' => 'Handsög OF1400 + Ryksuga',
                'image' => asset('products/OF1400+ryksuga.jpg'),
                'manufacturer' => 'Festool'
            ],
            [
                'id' => 'handsog-sett',
                'name' => 'Handsögs sett',
                'image' => asset('products/OF1400LAND.jpg'),
                'manufacturer' => 'Festool'
            ]
        ];

        if( $id != null ) {

            $product = $products[array_search($id, array_column($products, 'id'))];
            $product['relatedProducts'] = $this->related($id);

            return $product;

        }

        return $products;

    }

}
