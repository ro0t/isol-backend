<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use IGW\IsolProductList;
use App\Models\Product;
use App\Models\ProductLine;
use App\Models\ProductImages;
use App\Models\ProductInformation;
use App\Models\ProductCategory;
use App\Models\ProductSizes;
use App\Models\Manufacturer;

define('MAX_UPLOAD_IMAGES', 5);

class ProductController extends Controller {

    private $categories;
    private $manufacturers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->middleware('auth');

        $this->categories = ProductCategory::getParentsAndChildren();
        $this->manufacturers = Manufacturer::getActiveWithIds();

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $this->breadcrumbs('Products');

        $status = $request->has('status') && $request->get('status') != 0 ? $request->get('status') : 1;
        $products = Product::where('active', $status);

        if( $request->has('product_category_id') && !empty($request->get('product_category_id')) ) {
            $products = $products->where('product_category_id', $request->get('product_category_id'));
        }

        if( $request->has('manufacturer_id') && !empty($request->get('manufacturer_id')) ) {
            $products = $products->where('manufacturer_id', $request->get('manufacturer_id') );
        }

        return view('modules.products.list')
            ->with('status', $status)
            ->with('categories', $this->categories)
            ->with('manufacturers', $this->manufacturers)
            ->with('products', $products->paginate(50));
    }

    public function create() {

        $product = Product::create([
            'active' => 2, // Unpublished
        ]);

        if( $product ) {
            return redirect()->route('products.edit', $product->id);
        }

    }

    public function edit($id) {

        $product = Product::find($id);

        if(!$product) \App::abort(404);

        if( empty($product->name) ) {
            $this->breadcrumbs('Products', 'Create');
        } else {
            $this->breadcrumbs('Products', $product->name, 'Edit');
        }

        $sizes = ProductSizes::where('product_id', $product->id)->where('active', 1)->count();
        $images = ProductImages::getImagesFor($product->id);
        $technical = ProductInformation::getInformationFor($product->id);

        return view('modules.products.form')
            ->with('data', $product)
            ->with('images', $images)
            ->with('manufacturers', $this->manufacturers)
            ->with('categories', $this->categories)
            ->with('techInfo', $technical)
            ->with('productSizeCount', $sizes);

    }

    public function setMainImage(Request $request, $id) {

        $product = Product::find($id);

        if( $product ) {

            $update = ProductImages::setMainImage($product->id, $request->get('image'));

            if( $update ) {
                return response()->json(['message' => 'Updated main image.'], 200);
            } else {
                return response()->json(['message' => 'Could not update main image, please try again.'], 500);
            }

        }

        return response()->json(['message' => 'Could not find image with id ' . $id ], 404);

    }

    public function deleteImage($id) {

        $image = ProductImages::find($id);

        if( $image ) {

            $image->active = 0;

            if($image->save()) {
                return response()->json(['message' => 'Image has been deleted.'], 200);
            }

        }

        return response()->json(['message' => 'Could not delete image'], 500);

    }

    public function navision(Request $request) {

        $lines = ProductLine::findQuery($request->get('q'));

        return response()->json($lines);

    }

    public function delete($id) {

        $product = Product::find($id);

        if( $product != null ) {

            $product->active = 0;
            $product->save();

            return redirect()->back()->with('success', 'Product deleted successfully.');

        }

        return redirect()->back()->with('error', 'Something went wrong with deleting this product, please try again.');

    }

    public function validator($request, $isEditing = false) {

        if( $isEditing ) {
            // Put specific validator rules here for editing
        }

        return $request->validate([
            'name' => 'required|string|max:255',
            'manufacturer_id' => 'required|numeric',
            'product_category_id' => 'required|numeric',
            'description' => 'required|string',
            //'model_number' => 'numeric'
        ]);

    }

    public function setWebsiteVisibility($id) {

        $product = Product::find($id);

        if($product != null) {

            $product->active = $product->active == 1 ? 2 : 1;
            $product->save();

            return $this->success('Product was saved');

        }

        return $this->error('Product could not be updated, please refresh your page.');

    }

    public function change(Request $request, $id) {

        $this->validator($request);

        $product = Product::find($id);

        $this->storeTechnicalDescription( $id, $request->get('tech_desc') );

        if( !$this->storeProductDetails( $product, $request ) ) {
            return redirect()->route('products.edit', $product->id)->withInput()->with('error', 'Could not update product details, please try again.');
        }

        $this->storeProductFile('technical_information_file', $product, $request);
        $this->storeProductFile('safety_file', $product, $request);

        $prodSizes = $this->storeProductSizes('product_sizes', $product, $request);

        if( !$prodSizes ) {
            return redirect()->route('products.edit', $product->id)->with('error', 'There was something wrong with saving the product sizes, please try again.');
        }

        return redirect()->route('products.edit', $product->id)->with('success', 'Product saved');

    }

    public function addImages(Request $request, $id) {

        $product = Product::find($id);

        if($product != null) {

            if( $request->hasFile('images') ) {

                $count = 0;
                $images= [];

                $currentCount = ProductImages::activeCount($id);
                $uploadedCount = count($request->images);

                if( ($currentCount + $uploadedCount) > MAX_UPLOAD_IMAGES ) {
                    return response()->json([ 'message' => 'You can only have 5 images per product, delete some first.' ], 500);
                }

                foreach( $request->images as $image ) {

                    $ext = $image->extension();
                    $fileName = md5( $image->path() . time() ) . '.' . ($ext == 'jpeg' ? 'jpg' : $ext);
                    $image->storeAs('product-images', $fileName);

                    $path = '/product-images/' . $fileName;

                    if(($img = ProductImages::storeImage($id, $path))) {
                        $images[] = [ 'image' => $img->image, 'product_id' => $id, 'id' => $img->id ];
                        $count++;
                    }

                }

                return response()->json(['message' => $count . ' images uploaded successfully', 'images' => $images], 200);

            }

        }

        return response()->json([ 'message' => 'Could not find product with id: ' . $id], 404);

    }

    private function storeProductDetails( Product $product, Request $request ) {

        $description = $request->get('description');

        $product->navision_id                       = $request->get('navision_id');
        $product->name                              = $request->get('name');
        $product->slug                              = str_slug($request->get('name'));
        $product->manufacturer_id                   = $request->get('manufacturer_id');
        $product->product_category_id               = $request->get('product_category_id');
        $product->description                       = $request->get('description');
        $product->model_number                      = $request->get('model_number');
        $product->price                             = $request->get('price');
        $product->active                            = 1;    // Published

        return $product->save();

    }

    private function storeProductFile( $field, $product, $request ) {

        if( $request->hasFile($field) && $request->file($field)->isValid() ) {

            $fileName = md5(str_slug($product->name) . time() . mt_rand()) . '.pdf';
            $path = $request->{$field}->storeAs('files', $fileName);

            if( $path ) {
                if( $field == 'technical_information_file' ) {
                    $product->technical_information_file = '/files/' . $fileName;
                }

                if( $field == 'safety_file' ) {
                    $product->safety_file = '/files/' . $fileName;
                }

                $product->save();
            }

        }

    }

    private function storeProductSizes( $field, $product, $request ) {

        if( $request->hasFile($field) && $request->file($field)->isValid() ) {

            // Temporary read the file values and insert into ProductSizes
            if( ($handle = fopen($request->file($field)->getRealPath(), 'r')) !== false) {

                // Clear the old product sizes
                $this->removeProductSizes( $product->id, false );

                while(($data = fgetcsv($handle, 1000, ";")) !== false) {

                    if( isset($data[0]) && strlen($data[0]) > 0 ) {

                        // Size should always be the first value
                        $size = $data[0];

                        ProductSizes::addSize($product->id, $size);

                    }

                }

                fclose($handle);
                return true;

            }

            return false;

        }

    }

    public function removeProductSizes( $productId, $shouldRedirect = true ) {

        ProductSizes::clearSizes($productId);

        if( $shouldRedirect ) {
            return redirect()->route('products.edit', $productId)->with('success', 'Product sizes removed');
        }

    }

    private function storeTechnicalDescription( $productId, $data ) {

        if( $data != null && is_array($data) ) {

            ProductInformation::storeData($productId, $data);

        } else {

            // Removed values
            ProductInformation::where('product_id', $productId)->delete();

        }

    }

    // public function randomProductGenerator() {
    //
    //     $howMany = 50;
    //
    //     for($i = 0; $i < $howMany; $i++) {
    //
    //         $product = Product::where('active', 1)->inRandomOrder()->first();
    //         $randomCategory = ProductCategory::whereNotNull('parent')->where('active', 1)->inRandomOrder()->first();
    //
    //         $manufacturers = [1,2,3,4];
    //
    //         $prod = Product::create([
    //             'name' => $product->name,
    //             'product_category_id' => $randomCategory->id,
    //             'slug' => md5($product->slug . '-' . $i),
    //             'model_number' => mt_rand(),
    //             'navision_id' => '999999999' . $i,
    //             'description' => $product->description,
    //             'manufacturer_id' => $manufacturers[array_rand($manufacturers)],
    //             'active' => 1
    //         ]);
    //
    //         if( $prod->id ) {
    //
    //             $images = ['/product-images/20c0e01281987598b50db42cf516706c.jpg', '/product-images/1292d58e2dd8a3a83092b9f638ff689b.jpg', '/product-images/4ae01c0a18e3c2c093978b7c7a650db3.jpg', '/product-images/e3783b02e0e9b88abcbbb39349fa2838.jpg'];
    //
    //             ProductImages::create([
    //                 'product_id' => $prod->id,
    //                 'main_image' => 1,
    //                 'image' => $images[array_rand($images)]
    //             ]);
    //         }
    //
    //     }
    //
    //     return 'You got randomized!';
    //
    // }

}
