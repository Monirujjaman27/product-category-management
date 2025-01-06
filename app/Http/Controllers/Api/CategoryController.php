<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    public $model;
    public $db_table = 'categories';
    public function __construct()
    {
        $this->model = new Category();
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
                ->when($request->searchQuery, function ($q) use ($request) {
                    return $q->where('name', 'LIKE', '%' . $request->searchQuery . '%');
                })
                ->latest()
                ->when($request, function ($query) use ($request) {
                    if ($request->itemsPerPage === 'all') {
                        return $query->select('id', 'name')->get(); // Return all results if 'all' is selected
                    } else {
                        return $query->paginate($request->itemsPerPage);
                    }
                }, function ($query) {
                    // Default to returning all records if no pagination is specified
                    return $query->paginate(10);
                });

            return $this->sendResponse("Fetch Data", $data);
        } catch (Exception $e) {
            // Handle DB exception error
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
        // 👉 Check Validation
        $validator = Validator::make($request->all(), [
            'name'              => "required|unique:$this->db_table,name",
        ]);
        // 👉/=======when validation failed================
        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors(), 422);
        DB::beginTransaction();
        try {
            // 👉=============save data================
            $data = $this->model;
            $data->name                 = $request->name;
            $data->status               = $request->status ?? 'Active';
            $data->save();
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
        // 👉 Check Validation
        $validator = Validator::make($request->all(), [
            'name'              => "required|unique:$this->db_table,name,$id",
        ]);
        // 👉/=======when validation failed================
        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors(), 422);
        try {
            DB::beginTransaction();
            // 👉=============save data================
            $data = $this->model->find($id);
            $data->name                 = $request->name;
            $data->status               = $request->status ?? $data->status;
            $data->save();
            DB::commit();
            return $this->sendResponse("Updated Successfully", $data);
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
            $data = $this->model->with('products')->findOrFail($id);
            // $data->products()->detach();
            $data->delete();
            return $this->sendResponse("Delete Successfully");
        } catch (Exception $e) {
            // 👉// 👉=======handle DB exception error==========
            return $this->sendError('Exception Error', $e->getMessage(), $e->getCode());
        }
    }
}
