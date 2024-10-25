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
            // dd($post);
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
}