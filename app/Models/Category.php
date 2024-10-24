<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Common;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public static function saveData($post)
    {
        // try {
        $dataArray = [
            'name' => $post['name'],
            "parent_id" => $post['parent_id']
        ];
        if (!empty($post['image'])) {
            $fileName = Common::uploadFile('category', $post['image']);
            if (!$fileName) {
                return false;
            }
            $dataArray['image'] = $fileName;
        }
        if (!empty($post['id'])) {
            $dataArray['updated_at'] = Carbon::now();
            if (!Category::where('id', $post['id'])->update($dataArray)) {
                throw new Exception("Couldn't update Records", 1);
            }
        } else {
            $dataArray['created_at'] = Carbon::now();
            if (!Category::insert($dataArray)) {
                throw new Exception("Couldn't Save Records", 1);
            }
        }
        return true;
        // } catch (Exception $e) {
        //     throw $e;
        // }
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
        $query = Category::with('parent')
            ->selectRaw("(SELECT count(*) FROM categories) AS totalrecs, name, id,parent_id");
        if ($limit > -1) {
            $result = $query->limit($limit)->get();
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
