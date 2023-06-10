<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categores = Category::withCount('products')->get();
        // dd($categores->toArray());

        return view('products.categories.index')->with('categores', $categores);
    }

    public function create()
    {
        # code...
        return view('products.categories.create');
    }

    public function store(Request $request)
    {
        # code...
        $request->validate(
            [
                'category_name' => ['required', 'string'],
            ]
            ,
            [
                'category_name.required' => 'مطلوب حقل اسم الفئة',
                'category_name.string' => 'حقل اسم الفئة مطلوب يجب أن يحتوي اسم الفئة على أحرف فقط',
            ]
        );

        //  category_name

        $category_name = $request['category_name'];
        $category = new Category();
        $category->name = $category_name;
        $status = $category->save();
        session()->flash('status', $status);
        return redirect()->route('categories.index');
    }

    public function edit($category_id)
    {
        $category = Category::find($category_id);
        return view('products.categories.edit')->with('category', $category);
    }

    public function update(Request $request, $category_id)
    {
        # code...
        $request->validate(
            [
                'category_name' => ['required', 'string'],
            ]
            ,
            [
                'category_name.required' => 'مطلوب حقل اسم الفئة',
                'category_name.string' => 'حقل اسم الفئة مطلوب يجب أن يحتوي اسم الفئة على أحرف فقط',
            ]
        );
        $category_name = $request['category_name'];
        $category = Category::find($category_id);
        $category->name = $category_name;
        $updateStatus = $category->update();
        session()->flash('updateStatus', $updateStatus);
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        // $role =  Role::findById($id)->delete();
        // return redirect()->back();
        $categoryDestroy = Category::destroy($id);
        if ($categoryDestroy) {
            return response()->json(['icon' => 'success', 'title' => 'تم حذف الفئة بنجاح'], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => ' فشلت عملية حذف  الفئة'], 400);
        }
    }

    public function search(Request $request)
    {
        # code...
        // dd($request->toArray());
        $search = $request['search'];
        if ($search) {
            $category = Category::withCount('products')->where('name', 'like', '%' . $search . '%')->get();
            // dd($category->toArray());
            return view('products.categories.index')->with('categores', $category);

        } else {

            $categores = Category::withCount('products')->get();
            return view('products.categories.index')->with('categores', $categores);
        }
    }

    public function productReport($id)
    {
        $category = Category::with('products')->withCount('products')->find($id);
        // dd($category->toArray());
        return view('products.categories.productReport')->with('category', $category);
    }
}