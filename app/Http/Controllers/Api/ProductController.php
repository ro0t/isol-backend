<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;

class ProductController extends ResponseController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    protected function categories() {

        return $this->json([
            'products' => [
                [
                    'id' => 1,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Handverkfæri'
                    ]
                ],
                [
                    'id' => 2,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Rafmagnsverkfæri'
                    ]
                ],
                [
                    'id' => 3,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Festingar'
                    ]
                ],
                [
                    'id' => 4,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Kítti og efnavörur'
                    ]
                ],
                [
                    'id' => 5,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Mælitæki'
                    ]
                ],
                [
                    'id' => 6,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Aukahlutir'
                    ]
                ]
            ]
        ]);

    }

    protected function list() {

        return $this->json([
            'products' => [
                [
                    'id' => 'bhc',
                    'name' => 'BHC',
                    'image' => 'BHC.jpg',
                    'manufacturer' => 'Festool'
                ],
                [
                    'id' => 'borvelar',
                    'name' => '3x Borvélar',
                    'image' => 'borvélar.jpg',
                    'manufacturer' => 'Festool'
                ],
                [
                    'id' => 'conturo',
                    'name' => 'Conturo',
                    'image' => 'conturo.jpg',
                    'manufacturer' => 'Festool'
                ],
                [
                    'id' => 'ryksuga-ct-17',
                    'name' => 'Ryksuga CT-17',
                    'image' => 'CT17.jpg',
                    'manufacturer' => 'Festool'
                ],
                [
                    'id' => 'ryksuga-ctl26e',
                    'name' => 'Ryksuga CTL26E',
                    'image' => 'CTL26E.jpg',
                    'manufacturer' => 'Festool'
                ],
                [
                    'id' => 'skrufuvel-cxs',
                    'name' => 'Skrúfuvél CXS',
                    'image' => 'CXS.jpg',
                    'manufacturer' => 'Festool'
                ],
                [
                    'id' => 'dwc',
                    'name' => 'Negla DWC',
                    'image' => 'DWC.jpg',
                    'manufacturer' => 'Festool'
                ],
                [
                    'id' => 'handfraesari-xt-9',
                    'name' => 'Handfræsari XT-9',
                    'image' => 'handfræsarar.jpg',
                    'manufacturer' => 'Festool'
                ],
                [
                    'id' => 'midi-ryksuga',
                    'name' => 'Ryksuga MIDI',
                    'image' => 'MIDI.jpg',
                    'manufacturer' => 'Festool'
                ],
                [
                    'id' => 'handsog-OF1400',
                    'name' => 'Handsög OF1400',
                    'image' => 'OF1400.jpg',
                    'manufacturer' => 'Festool'
                ],
                [
                    'id' => 'handsog-OF1400-med-ryksugu',
                    'name' => 'Handsög OF1400 + Ryksuga',
                    'image' => 'OF1400+ryksuga.jpg',
                    'manufacturer' => 'Festool'
                ],
                [
                    'id' => 'handsog-sett',
                    'name' => 'Handsögs sett',
                    'image' => 'OF1400LAND.jpg',
                    'manufacturer' => 'Festool'
                ]
            ]
        ]);

    }

    public function detail($id) {

        return $this->json([
            'product' => [
                'id' => $id,
                'name' => 'Handsögs sett',
                'image' => 'OF1400LAND.jpg',
                'manufacturer' => 'Festool'
            ]
        ]);

    }

}
