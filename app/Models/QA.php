<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Exception;

class QA extends Model
{
    use HasFactory;

    // public function children()
    // {
    //     return $this->hasMany(QA::class, 'parent_id');
    // }

    // public function parent()
    // {
    //     return $this->belongsTo(QA::class, 'parent_id');
    // }

    public function userDetails()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productDetails()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function adminDetails()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public static function saveData($post)
    {
        try {
            $dataArray = [
                [
                    'user_id' => $post['user_id'],
                    'product_id' => $post['product_id'],
                    'question' => $post['question'],
                    'created_at' => Carbon::now(),
                ]
            ];
            if (!QA::insert($dataArray)) {
                throw new Exception("Couldn't Save Records", 1);
            }

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function list($post)
    {
        // try {
        $get = $post;
        $sorting = !empty($get['order'][0]['dir']) ? $get['order'][0]['dir'] : 'asc';
        $orderby = " order_number " . $sorting . "";
        if (!empty($get['order'][0]['column']) && $get['order'][0]['column'] == 6) {
            $orderby = " order_number " . $sorting . "";
        }
        foreach ($get['columns'] as $key => $value) {
            $get['columns'][$key]['search']['value'] = trim(strtolower(htmlspecialchars($value['search']['value'], ENT_QUOTES)));
        }
        if (!empty($post['type']) && $post['type'] === "trashed") {
            $cond = " status = 'N' ";
        }
        if ($get['columns'][1]['search']['value'])
            $cond .= " and lower(name) like '%" . $get['columns'][1]['search']['value'] . "%'";
        $limit = 15;
        $offset = 0;
        if (!empty($get["length"]) && $get["length"]) {
            $limit = $get['length'];
            $offset = $get["start"];
        }
        $query = QA::with('userDetails', 'productDetails', 'adminDetails')
            ->selectRaw("(SELECT COUNT(*) FROM q_a_s) 
        AS totalrecs, id, user_id, admin_id, product_id, question, answer");
        if ($limit > -1) {
            $result = $query->offset($offset)->limit($limit)->get();
        } else {
            $result = $query->get();
        }
        if ($result) {
            $ndata = $result;
            $ndata['totalrecs'] = @$result[0]->totalrecs ? $result[0]->totalrecs : 0;
            $ndata['totalfilteredrecs'] = @$result[0]->totalrecs ? $result[0]->totalrecs : 0;
        } else {
            $ndata = array();
        }
        return $ndata;
        // } catch (Exception $e) {
        //     throw $e;
        // }
    }
}
