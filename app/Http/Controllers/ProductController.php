<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //

    public function index()
    {
        $products = Product::with('category')->get();

        foreach ($products as $product) {
            $logo_link = Storage::url($product->image);
            $product->image = $logo_link;
        }
        // dd($products->toArray());
        return view('products.index')->with('products', $products);

    }

    public function create()
    {
        $categores = Category::all();
        return view('products.create')->with('categores', $categores);
    }

    public function store(PreductRequest $request)
    {
        $product = new Product();
        $product->name = $request->product_name;
        $product->base_price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        if ($request->production_date) {
            $product->production_date = $request->production_date;
        }
        if ($request->expiry_date) {
            $product->expiry_date = $request->expiry_date;
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'uplodes/products/images/';
            $name = time() + rand(1, 1000000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path . $name, file_get_contents($image));
            $product->image = $path . $name;
        }

        if ($request->description) {
            $product->description = $request->description;
        }

        $status = $product->save();
        session()->flash('status', $status);
        return redirect()->route('products.index');

    }



    public function edit($id)
    {
        $categores = Category::all();
        $product = Product::find($id);
        $logo_link = Storage::url($product->image);
        $product->image = $logo_link;

        // dd($product->toArray());
        return view('products.edit')->with(['product' => $product, 'categores' => $categores]);

    }

    public function update(PreductRequest $request, $id)
    {
        $product = Product::find($id);
        // dd($request->category_id);
        $product->name = $request->product_name;
        $product->base_price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        if ($request->production_date) {
            $product->production_date = $request->production_date;
        }
        if ($request->expiry_date) {
            $product->expiry_date = $request->expiry_date;
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'uplodes/products/images/';
            $name = time() + rand(1, 1000000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path . $name, file_get_contents($image));
            $product->image = $path . $name;
        }

        if ($request->description) {
            $product->description = $request->description;
        }

        $updateStatus = $product->save();
        session()->flash('updateStatus', $updateStatus);
        return redirect()->route('products.index');

    }


    public function destroy($id)
    {
        $productDestroy = Product::destroy($id);
        if ($productDestroy) {
            return response()->json(['icon' => 'success', 'title' => 'تم الحذف بنجاح'], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'فشلت عملية الحذف !!'], 400);
        }
    }


    public function createDiscount($id)
    {
        $product = Product::find($id);
        return view('products.createDiscount')->with('product', $product);
    }

    public function discount(Request $request, $id)
    {
        # code...
        $request->validate(
            [
                'discount' => 'required|numeric|min:0',
            ],
            [
                'discount.required' => 'الحقل مطلوب',
                'discount.numeric' => 'يجب أن يكون رقم',
            ]
        );


        $product = Product::find($id);
        $discountRate = ($request['discount'] / 100);
        $disCount = $product->base_price * $discountRate;
        $price_after_discount = $product->base_price - $disCount;
        $product->price_after_discount = $price_after_discount;
        $product->discount = $request['discount'];
        $statusDisCount = $product->save();
        session()->flash('statusDisCount', $statusDisCount);
        return redirect()->route('products.index');

    }
    // $licenses = License::where('productName','like','%'.$search.'%')
    // ->orWhere('licenseNumber','like','%'.$search.'%')
    // ->orWhereHas('client', function ($query) use ($search) {
    //     $query->where('name', 'like', '%'.$search.'%');
    // })
    // ->orderBy('id')
    // ->paginate(20);

    public function search(Request $request)
    {
        $search = $request->search;
        if ($search) {
            $products = Product::with('category')
                ->where('products.name', 'LIKE', "%{$search}%")
                ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('categories.name', 'like', '%'.$search.'%');
                    })
                ->get();

                foreach ($products as $product) {
                $logo_link = Storage::url($product->image);
                $product->image = $logo_link;
            }
            return view('products.index')->with('products', $products);

        } else {
            $products = Product::with('category')->get();

            foreach ($products as $product) {
                $logo_link = Storage::url($product->image);
                $product->image = $logo_link;
            }
            // dd($products->toArray());
            return view('products.index')->with('products', $products);
        }
    }
}