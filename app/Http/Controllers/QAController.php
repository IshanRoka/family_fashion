<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use App\Models\Common;
use App\Models\QA;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class QAController extends Controller
{
    public function save(Request $request)
    {

        try {
            $post = $request->all();
            $type = 'success';
            $message = 'question send successfully';
            DB::beginTransaction();
            $result = QA::saveData($post);
            if (!$result) {
                throw new Exception('Could not order');
            }
            DB::commit();
        } catch (ValidationException $e) {
            $type = 'error';
            $message = $e->getMessage();
        } catch (QueryException $e) {
            DB::rollBack();
            $type = 'error';
            // $message = $this->queryMessage;
        } catch (Exception $e) {
            DB::rollBack();
            $type = 'error';
            $message = $e->getMessage();
        }

        return response()->json(['type' => $type, 'message' => $message]);
    }



    public function list(Request $request)
    {
        // try {
        $post = $request->all();
        $data = QA::list($post);
        $i = 0;
        $array = [];
        $filtereddata = ($data['totalfilteredrecs'] > 0 ? $data['totalfilteredrecs'] : $data['totalrecs']);
        $totalrecs = $data['totalrecs'];
        unset($data['totalfilteredrecs']);
        unset($data['totalrecs']);
        foreach ($data as $row) {
            $array[$i]['sno'] = $i + 1;
            $array[$i]['question_and_answer'] = $row->question_and_answer;
            $array[$i]['user_id'] = $row->userDetails->username;
            $array[$i]['admin_id'] = $row->adminDetails->username;
            $array[$i]['product_id'] = $row->productDetails->name;
            $array[$i]['question'] = $row->question;
            $array[$i]['answer'] = $row->answer;
            $action = '';
            $action .= '<span style="margin-left: 10px;"></span>';
            $action .= '<a href="javascript:;" class="editNews" title="Edit Data" data-id="' . $row->id . '"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
            $action .= '<span style="margin-left: 10px;"></span>';
            $action .= '|';
            $action .= '<span style="margin-left: 10px;"></span>';
            $action .= ' <a href="javascript:;" class="deleteNews" title="Delete Data" data-id="' . $row->id . '"><i class="fa fa-trash text-danger"></i></a>';
            $array[$i]['action'] = $action;
            $i++;
        }
        if (!$filtereddata)
            $filtereddata = 0;
        if (!$totalrecs)
            $totalrecs = 0;
        // } catch (QueryException $e) {
        //     $array = [];
        //     $totalrecs = 0;
        //     $filtereddata = 0;
        // } catch (Exception $e) {
        //     $array = [];
        //     $totalrecs = 0;
        //     $filtereddata = 0;
        // }
        return response()->json(['recordsFiltered' => $filtereddata, 'recordsTotal' => $totalrecs, 'data' => $array]);
    }

    public function form(Request $request)
    {
        try {
            $post = $request->all();
            $prevPost = [];
            $category = QA::get();
            if (!empty($post['id'])) {
                $prevPost = QA::where('id', $post['id'])
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
        return view('backend.Q&A.form', $data);
    }


}