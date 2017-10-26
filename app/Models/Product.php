<?php

namespace App\Models;

class Product {

    public function all( $id = null ) {

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
            return $products[array_search($id, array_column($products, 'id'))];
        }

        return $products;

    }

}
