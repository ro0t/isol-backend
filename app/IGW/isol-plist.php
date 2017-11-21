<?php

namespace IGW;

use App\Models\ProductLine;

class IsolProductList {

    private $path;
    private $storeName;
    private $directory;

    public function __construct() {

        $this->storeName = md5('isol-product-list-csv') . '.csv';
        $this->directory = 'product-data';

        $this->path = storage_path() . '/app/' . $this->getDirectory() . '/' . $this->getStoreName();

        // If your CSV document was created or is read on a Macintosh computer, add
        // the following lines before using the library to help PHP detect line ending.
        if( !ini_get("auto_detect_line_endings") ) {
            ini_set("auto_detect_line_endings", 1);
        }

    }

    public function getDirectory() {

        return $this->directory;

    }

    public function getStoreName() {

        return $this->storeName;

    }

    public function storeLines() {

        if( file_exists($this->path) ) {

            $csv = file($this->path, FILE_SKIP_EMPTY_LINES);

            foreach( $csv as $item ) {

                $values = explode(';', $item);
                $id = $values[0];
                $title = utf8_encode($values[1]);

                if(is_numeric($values[0])) {

                    ProductLine::create([
                        'nav_product_id' => $id,
                        'nav_product_title' => $title
                    ]);

                }

            }

            return true;

        }

        return false;

    }

}
