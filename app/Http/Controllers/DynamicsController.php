<?php

namespace App\Http\Controllers;

use App\IGW\ISoapClient;
use App\Models\Product;
use App\Models\ProductNavisionData;

class DynamicsController extends Controller {
    protected $client;
    private $startTime;

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');

        $this->startTime = microtime(true);

        $this->client = new ISoapClient(
            env('NAV_URL'),
            env('NAV_DOMAIN') . '\\' . env('NAV_USER'),
            env('NAV_PASS')
        );
    }

    public function fullSync() {
        $this->breadcrumbs('Products', 'Sync prices');
        return view('modules.products.sync');
    }

    public function singleSync($id) {
        $product = Product::select('id', 'navision_id', 'active')
            ->whereNotNull('navision_id')
            ->where('id', $id)
            ->where('active', 1)
            ->first();

        if( $product ) {
            $result = $this->syncPrices($product->navision_id);
            if ($result) { $this->mapResult($product, $result); }
            return redirect()->route('products.edit', $product->id);
        } else {
            return \App::abort(500);
        }
    }

    public function sync() {
        // Increase the timeout limit, this request may take some time.
        set_time_limit(25*60);

        $products = Product::select('id', 'navision_id', 'active')
            ->whereNotNull('navision_id')
            ->where('active', 1)
            ->where('last_nav_sync_date', '<', date('Y-m-d H:i:s', time() - (25 * 60)))
            ->get();

        $productCount = count($products);
        $successfulResults = 0;

        foreach ($products as $product) {
            $result = $this->syncPrices($product->navision_id);

            if ($result) {
                $this->mapResult($product, $result);

                // Update the time
                $product->update([
                    'last_nav_sync_date' => date('Y-m-d H:i:s', time())
                ]);

                $successfulResults++;
            }
        }

        $seconds = microtime(true) - $this->startTime;
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);

        return 'Successful results ' . $successfulResults . ' out of total ' . $productCount . ' products - and it took ' . sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
    }

    private function mapResult(Product $product, $navisionResult)
    {
        $updateArray = [
            'UnitCost' => $navisionResult->Unit_Cost,
            'UnitPrice' => $navisionResult->Unit_Price,
            'UnitPricePerSalesUOM' => $navisionResult->UnitPricePerSalesUOM,
            'UnitPricePerSalesUOMVAT' => $navisionResult->UnitPricePerSalesUOMVAT
        ];

        if (($navData = $product->navisionData) != null) {
            // Update old
            $navData->update($updateArray);
        } else {
            ProductNavisionData::create(array_merge($updateArray, ['product_id' => $product->id]));
        }
    }

    private function syncPrices($navisionProductId)
    {
        try {
            $response = $this->client->ReadByRecId(['recId' => 'Item: ' . $navisionProductId]);
            return isset($response->ItemListWS) ? $response->ItemListWS : false;
        } catch (\SoapFault $e) {
            return false;
        }
    }

}