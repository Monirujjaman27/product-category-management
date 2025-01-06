<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    public $model;
    public $db_table = 'products';
    public function __construct()
    {
        $this->model = new Product();
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_product_categories(Request $request)
    {

        try {
            $data['products'] = $this->model->with('categories')
                ->latest()
                ->paginate($request->itemsPerPage ?? 20);
            $data['categories'] = Category::withCount('products')
                ->latest()
                ->get();
            return $this->sendResponse("Fetch Data", $data);
        } catch (Exception $e) {
            // 👉// 👉=======handle DB exception error==========
            return $this->sendError('Exception Error', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {
            $data = $this->model
                ->with('categories')
                ->when($request->searchQuery, function ($q) use ($request) {
                    return $q->where('name', 'LIKE', '%' . $request->searchQuery . '%');
                })
                ->latest()
                ->paginate($request->itemsPerPage ?? 10);
            return $this->sendResponse("Fetch Data", $data);
        } catch (Exception $e) {
            // 👉// 👉=======handle DB exception error==========
            return $this->sendError('Exception Error', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->id) return $this->update($request, $request->id);
        // 👉 Check Validation
        $validator = Validator::make($request->all(), [
            'name'        => "required|unique:$this->db_table,name",
            'categories'  => "required|array",
            'price'       => "required|numeric|min:1",
            'image'       => 'required|mimes:jpeg,png,jpg|max:2048'
        ]);
        // 👉/=======when validation failed================
        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors(), 422);
        DB::beginTransaction();

        try {
            // 👉=============save data================
            $data = $this->model;
            $data->name                = $request->name;
            $data->price               = $request->price;
            $data->status              = $request->status ?? 'Active';
            $data->image               = $request->image ? $this->fileUpload($request->image, 'product/') : null;
            $data->save();
            // Attach categories after product save
            $data->categories()->attach($request->categories); // Ensure categories exist in DB first
            DB::commit();
            return $this->sendResponse("Created Successfully", $data);
        } catch (Exception $e) {
            DB::rollBack();
            // 👉=======handle DB exception error==========
            return $this->sendError('Exception Error', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        // 👉 Check Validation
        $validator = Validator::make($request->all(), [
            'name'        => "required|unique:$this->db_table,name,$id",
            'categories'  => "required|array",
            'price'       => "required|numeric|min:1",
            'image'       => 'mimes:jpeg,png,jpg|max:2048'
        ]);
        // 👉/=======when validation failed================
        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors(), 422);
        DB::beginTransaction();

        try {
            // 👉=============save data================
            $data = $this->model->findOrFail($id);
            $data->name                = $request->name;
            $data->price               = $request->price;
            $data->status              = $request->status ?? $data->status;
            $data->image               = $request->image ? $this->fileUpload($request->image, 'product/', $data->image) : null;
            $data->save();
            // 👉 Remove all previous category associations
            $data->categories()->sync($request->categories); // This will automatically delete old associations and add new ones
            DB::commit();
            $data = $this->model->with('categories')->find($id);
            return $this->sendResponse("Update Successfully", $data);
        } catch (Exception $e) {
            DB::rollBack();
            // 👉=======handle DB exception error==========
            return $this->sendError('Exception Error', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->model->with('categories')->findOrFail($id);
            $data->categories()->detach();
            $data->delete();
            return $this->sendResponse("Delete Successfully");
        } catch (Exception $e) {
            // 👉// 👉=======handle DB exception error==========
            return $this->sendError('Exception Error', $e->getMessage(), $e->getCode());
        }
    }
}
