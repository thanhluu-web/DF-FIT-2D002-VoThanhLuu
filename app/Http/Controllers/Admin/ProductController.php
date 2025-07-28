<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = config('app.item_per_page');
        $sortBy = $request->get('sort_by');
        $sortOrder = $request->get('sort_order');

        $keyword = $request->get('keyword','');
        $columns = [
            'stt' => 'STT',
            'name' =>  'Tên sản phẩm',
            'image' => 'Hình ảnh',
            'sku' => 'Mã sản phẩm',
            'unit' => 'Đơn vị tính',
            'product_type' => 'Loại hàng',
            'shelf_life' => 'Hạn sử dụng',
            'status' =>'Trạng thái',
            'created_at' =>'Ngày tạo',
            'updated_at' => 'Ngày chỉnh sửa',
            'action' => 'Chức năng',
        ];

        $searchColumn = $request->get('search_column','name');

        $allowedSort = ['name','sku','unit','product_type','shelf_life','status','created_at','updated_at',''];
        $isSorted = false;
        
        if (in_array($sortBy, $allowedSort) && in_array($sortOrder, ['asc', 'desc'])) {
            $isSorted = true;
        } else {
            $sortBy = null;
            $sortOrder = null;
        }
        
        $products = Product::where($searchColumn ,'LIKE', "%$keyword%")->orderBy($sortBy ?? 'created_at',$sortOrder ?? 'desc')->paginate($perPage)->appends([
        'sort_by'=>$sortBy,
        'sort_order'=>$sortOrder
        ]);

        return view('admin.pages.product-management.product-list',compact('products','sortBy','sortOrder','isSorted','keyword','columns','searchColumn'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.product-management.product-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $productRequest)
    {
        $product = $productRequest->all();

        do{
            $sku = $this->generateSKU();
            $exists = Product::where('sku',$sku)->exists();
        }
        while($exists);
        $product['sku'] = $sku;

        if($productRequest->hasFile('image')){
            $file = $productRequest->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = "product_img_".uniqid().".$extension";
            $file->move(public_path("product_images"), $fileName);
            $product['image'] = $fileName;
        }

        Product::create($product);
        return redirect()->route('product.list')->with('success','Bạn đã thêm sản phẩm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail(Product $product)
    {
        return view('admin.pages.product-management.product-detail',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $productRequest, Product $product)
    {
        $updateProduct = $productRequest->all();

        if($productRequest->hasFile('image')){
            if ($product->image) {
                 $oldImagePath = public_path('product_images/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);  // xóa file cũ
                }
            }
            $file = $productRequest->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = "product_img_".uniqid().".$extension";
            $file->move(public_path("product_images"), $fileName);
            $updateProduct['image'] = $fileName;
        }
        $product->update($updateProduct);
        return redirect()->route('product.list')->with('success','Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {   
            $product->delete();
            return redirect()->route('product.list')->with('success','Bạn đã xóa sản phẩm');
              if ($product->image) {
                    $oldImagePath = public_path('product_images/' . $product->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);  // xóa file cũ
                    }
                };  

        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa sản phẩm: '.$e->getMessage());
        }
    }
    private function generateSKU(){
        $letters='';
        for ($i = 0; $i < 3; $i++) {
        $letters .= chr(rand(65, 90)); // mã ASCII A-Z
        }
        return $letters . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
    }

}
