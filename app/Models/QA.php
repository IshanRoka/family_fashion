<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Exception;

class QA extends Model
{
    use HasFactory;
    public static function saveData($post)
    {
        // try {
        $dataArray = [
            [
                'user_id' => $post['user_id'],
                'product_id' => $post['product_id'],
                'questionAndanswer' => $post['questionAndanswer'],
                'created_at' => Carbon::now(),
            ]
        ];
        dd($dataArray);
        if (!QA::insert($dataArray)) {
            throw new Exception("Couldn't Save Records", 1);
        }

        return true;
        // } catch (Exception $e) {
        //     throw $e;
        // }
    }
}