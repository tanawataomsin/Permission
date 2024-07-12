<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $search = $request->input('search');

        // $product = Product::query()->orderBy('created_at', 'ASC')
        //     ->when($search, function ($query, $search) {
        //         return $query->where('id', 'LIKE', "%{$search}%")
        //             ->orWhere('title', 'LIKE', "%{$search}%")
        //             ->orWhere('price', 'LIKE', "%{$search}%")
        //             ->orWhere('product_code', 'LIKE', "%{$search}%")
        //             ->orWhere('CREATE_BY', 'LIKE', "%{$search}%");
        //     })

        //     ->paginate(5);

        $search = $request->input('search');
        // dd($search);

        // $product = Product::with('user')
        $product = Product::query()->with('user')

            ->when($search, function ($product, $search) {
                $product->whereRelation("user", "name", 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'ASC')
            ->paginate(5);


        return view('products.index', compact('product'))
            ->with('search', $search);

        // dd($product);

        // $search = $request->input('search');

        //     ->paginate(5);

        // return view('companies.index', compact('companies'))
        //     ->with('search', $search);


        // return view('products.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'product_code' => 'required|max:50|unique:products,product_code,'
        ]);


        $request->merge([
            'create_by' => auth()->user()->id,
        ]);


        Product::create($request->all());

        return redirect()->route('products')->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'product_code' => 'required|max:50|unique:products,product_code,',
        ]);

        $product->update($request->only(['title', 'price', 'product_code']));

        return redirect()->route('products')->with('success', 'Product updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = $request->id;
        DB::table('products')->where('id',  $data)->delete();
        return response()->json(200);
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return redirect()->route('products.index')->with('success', 'Products imported successfully.');
    }
}
