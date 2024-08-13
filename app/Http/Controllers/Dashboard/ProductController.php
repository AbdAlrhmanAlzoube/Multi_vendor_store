<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Models\Tag;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::with(['category', 'store'])->paginate();

        return view('dashboard.products.index', compact('products'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        $product = Product::find($id);
        $tags=implode(',',$product->tags()->pluck('name')->toArray());
        // dd($tags);
        // $tags = $product->tags()->pluck('name')->toArray();
        return view('dashboard.products.edit', compact('product','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {

        $product->update($request->except('tags'));
        $tags = explode(',', $request->post('tags'));
        // dd($tags);

        // جلب جميع العلامات الموجودة مسبقاً
        $existingTags = Tag::pluck('id', 'slug')->toArray();
        $tag_ids = [];
    
        foreach ($tags as $t_name) {
            $t_name = trim($t_name); // إزالة أي فراغات زائدة
            $slug = Str::slug($t_name);
    
            // التحقق مما إذا كانت العلامة موجودة بالفعل
            if (isset($existingTags[$slug])) {
                // إذا كانت العلامة موجودة، استخدم معرفها
                $tag_ids[] = $existingTags[$slug];
            } else {
                // إذا لم تكن العلامة موجودة، أنشئ علامة جديدة
                $tag = Tag::create([
                    'name' => $t_name,
                    'slug' => $slug
                ]);
    
                // أضف معرف العلامة الجديدة إلى القائمة
                $tag_ids[] = $tag->id;
                // تحديث مجموعة العلامات الموجودة
                $existingTags[$slug] = $tag->id;
            }
        }
    
        // مزامنة العلامات مع المنتج
        $product->tags()->sync($tag_ids);
        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
