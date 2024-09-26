<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Common;
use App\Models\Product;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{

    public function index()
    {
        return view('backend.product.index');
    }

    /* save */
    public function save(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = 'Records saved successfully';
            DB::beginTransaction();
            $result = Product::saveData($post);
            if (!$result) {
                throw new Exception('Could not save record', 1);
            }
            DB::commit();
        } catch (ValidationException $e) {
            $type = 'error';
            $message = $e->getMessage();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    // Get list
    public function list(Request $request)
    {
        try {
            $post = $request->all();
            $data = Product::list($post);
            $i = 0;
            $array = [];
            $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
            $totalrecs = $data['totalrecs'];
            unset($data['totalfilteredrecs']);
            unset($data['totalrecs']);
            foreach ($data as $row) {
                $array[$i]['sno'] = $i + 1;
                $array[$i]['name'] = $row->name;
                $array[$i]['category'] = $row->category_name->name;
                $array[$i]['size'] = $row->size;
                $array[$i]['description'] = $row->description;
                $array[$i]['color'] = $row->color;
                $array[$i]['price'] = $row->price;
                $array[$i]['material'] = $row->material;
                $array[$i]['stock_quantity'] = $row->stock_quantity;
                $image = asset('images/no-image.jpg');
                if (!empty($row->image) && file_exists(public_path('/storage/product/' . $row->image))) {
                    $image = asset("storage/product/" . $row->image);
                }
                $array[$i]["image"] = '<img src="' . $image . '" height="30px" width="30px" alt="image"/>';
                $action = '';
                if (!empty($post['type']) && $post['type'] != 'trashed') {
                    $action .= ' <a href="javascript:;" class="viewPost" title="View Data" data-id="' . $row->id . '"><i class="fa-solid fa-eye" style="color: #008f47;"></i></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>';
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>';
                    $action .= '<a href="javascript:;" class="editNews" title="Edit Data" data-id="' . $row->id . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                    $action .= '<span style="margin-left: 10px;"></span>';
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>';
                } else if (!empty($post['type']) && $post['type'] == 'trashed') {
                    $action .= '<a href="javascript:;" class="restore" title="Restore Data" data-id="' . $row->id . '"><i class="fa-solid fa-undo text-success"></i></a> ';
                    $action .= '<span style="margin-left: 10px;"></span>';
                    $action .= '|';
                    $action .= '<span style="margin-left: 10px;"></span>';
                }
                $action .= ' <a href="javascript:;" class="deleteNews" title="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
                $array[$i]['action'] = $action;
                $i++;
            }
            if (!$filtereddata)
                $filtereddata = 0;
            if (!$totalrecs)
                $totalrecs = 0;
        } catch (QueryException $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        } catch (Exception $e) {
            $array = [];
            $totalrecs = 0;
            $filtereddata = 0;
        }
        return response()->json(['recordsFiltered' => $filtereddata, 'recordsTotal' => $totalrecs, 'data' => $array]);
    }

    //filled the form
    public function form(Request $request)
    {
        try {
            $post = $request->all();
            $prevPost = [];
            // $program = Program::with(relations: 'program', 'course')->where('program_id', $request->id)->where('status', 'Y')->first();
            $category = Category::get();
            if (!empty($post['id'])) {
                $prevPost = Product::where('id', $post['id'])
                    ->where('status', 'Y')
                    ->first();
                if (!$prevPost) {
                    throw new Exception("Couldn't found details.", 1);
                }
            }
            $data = [
                'prevPost' => $prevPost,
                'category' => $category,
            ];
            if ($prevPost->image) {
                $data['image'] = '<img src="' . asset('/storage/product') . '/' . $prevPost->image . '" class="_image" height="160px" width="160px" alt="' . ' No image"/>';
            } else {
                $data['image'] = '<img src="' . asset('/no-image.jpg') . '" class="_image" height="160px" width="160px" alt="' . ' No image"/>';
            }
            $data['type'] = 'success';
            $data['message'] = 'Successfully get data.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.product.form', $data);
    }

    // view details
    public function view(Request $request)
    {
        try {
            $post = $request->all();
            $productDetails = Product::with('category_name')
                ->where('id', $post['id'])
                ->where('status', 'Y')
                ->first();
            $data = [
                'productDetails' => $productDetails,
            ];
            $data['type'] = 'success';
            $data['message'] = 'Successfully fetched data of course.';
        } catch (QueryException $e) {
            $data['type'] = 'error';
            $data['message'] = $this->queryMessage;
        } catch (Exception $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return view('backend.product.view', $data);
    }

    // Delete
    public function delete(Request $request)
    {
        try {
            $type = 'success';
            $message = 'Record deleted successfully';
            $directory = storage_path('app/public/Course');
            $post = $request->all();
            $class = new Product();
            DB::beginTransaction();
            $result = Common::deleteCoureRelation($post, $class, $directory);
            if (!$result) {
                throw new Exception("Couldn't delete record", 1);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }

    public function restore(Request $request)
    {
        try {
            $post = $request->all();
            $type = 'success';
            $message = "Post restored successfully";
            DB::beginTransaction();
            $result = Product::restoreData($post);
            if (!$result) {
                throw new Exception("Could not restore Post. Please try again.", 1);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['type' => $type, 'message' => $message]);
    }
}