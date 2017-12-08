<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Manufacturer;

class Frontpage extends Model {

    protected $table = 'frontpage';
    protected $primaryKey = 'id';
    protected $guarded = [];

    private $types = [
        'MANUFACTURER' => 'Manufacturer',
        'NEWS' => 'News',
        'SLIDESHOW' => 'Slideshow'
    ];

    public function getTypes() { return $this->types; }

    public function getRowItems( $rowId ) {

        $items = self::where('row_id', $rowId)->orderBy('row_placement', 'ASC')->get();

        if( $items ) {

            foreach( $items as $item ) {

                // Fetch additionally required data
                $item->generatedData = $this->getDataFor( $item->type, json_decode($item->data) );
                $item->moduleTitle = ( isset($item->generatedData->name) ) ? $item->generatedData->name : 'N/A';

            }

            return $items;

        }

        return null;

    }

    public function getDataFor( $type, $jsonData ) {

        if( $type == 'MANUFACTURER' ) {

            if( isset($jsonData->manufacturer) ) {

                $manufacturer = Manufacturer::select('name', 'slug as id', 'image', 'banner')->where('active', 1)->where('slug', $jsonData->manufacturer)->first();

                $manufacturer->image = asset($manufacturer->image);
                $manufacturer->banner = asset($manufacturer->banner);

                return $manufacturer;

            }

        }

        if( $type == 'NEWS' ) {

            return (object) [
                'name' => 'Latest news',
            ];

        }

        if( $type == 'SLIDESHOW' ) {

            $jsonData->name = 'Auto-rotating images';

            return $jsonData;

        }

        return null;

    }

    public function getTitle() {

        if( $this->type == 'MANUFACTURER' ) {

            $data = json_decode( $this->data );

            if( isset($data->manufacturer) ) {

                $manufacturer = Manufacturer::select('name', 'slug as id', 'image')->where('active', 1)->where('slug', $data->manufacturer)->first();
                return ( $manufacturer ) ? $manufacturer->name : 'N/A';


            }

        }

        if( $this->type == 'NEWS' ) {

            return 'Latest news';

        }

        if( $this->type == 'SLIDESHOW' ) {

            return 'Auto-rotating images';

        }

        return 'N/A';

    }

}
