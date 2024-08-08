<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index(Request $request)
    //  $request->input();//get data from colum
    //  $request->query();//get data from route parametar

    public function index(Request $request)
    {
        // $request=request();
       //select a.*form 
       //b.name as parent_name categories as a
       //LEFT JONE CATEGORIES  b on b.id=a.parent_id


        $categories = Category::leftjoin('categories as parent','parent.id','=','categories.parent_id')
        ->select([
            'categories.*',
            'parent.name as parent_name'
        ])
        ->Filter($request->query())
        ->orderby('name','asc')
       // ->withTrashed()  //بترجع مع البيانات المحذوفة
        // ->onlyTrashed()   
        ->paginate();                                   //latest() he scope use sorting 
       
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all(); //
        $category = new Category(); //مشان مرق اوبجكت فاضي للصفحة ال create 
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        // Merge slug into the request data
        $request->merge(['slug' => Str::slug($request->post('name'))]);
       
        $data = $request->except('image');
        

        $data['image'] = $this->uplodeImage($request);
        $category = Category::create($data);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully.');
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
    public function edit(string $id)
    {
        $category = Category::find($id);
        if (!$category)
            return to_route('dashboard.categories.index')->with('info', 'Record not found!');


        //select *from categories where id <> $id 
        //and( parent_id Is Null parent_id<>$id)
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->WhereNull('parent_id')
                    ->orwhere('parent_id', '<>', $id);
            })
            ->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.e
     */
    public function update(CategoryRequest $request, string $id)
    {
        //  $request->validate(Category::rules($id));
        $category = Category::find($id);

        $old_image = $category['image']; //store old_image

        $data = $request->except('image');

        $new_image = $this->uplodeImage($request);

        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully.');

        // if (!empty($category->image) && Storage::disk('public')->exists($category->image)) {
        //     Storage::disk('public')->delete($category->image);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!empty($category->image) && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();


        //  Category::destroy($id); //=>Category=where('id','=',$id)->delete();
        return redirect()->route('dashboard.categories.index')->with('danger', 'Category deleted successfully.');
    }

    protected function uplodeImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image'); //return uplodedfile object 

        $path = $file->store('uplodes', ['disk' => 'public']);
        return $path;
    }

    public function trash()
    {
       $categories=Category::onlyTrashed()->paginate();
       return view('dashboard.categories.trash', compact('categories')); 
    }

    public function restore(Request $request,$id)
    {
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return to_route('dashboard.categories.index')->with('succes','Category Restored!');

    }
    public function forceDelete($id)
    {
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return to_route('dashboard.categories.trash')->with('succes','Category deleted forever!');

    }
}
