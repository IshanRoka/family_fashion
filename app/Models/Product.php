<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Carbon\Carbon;
use Exception;

class Product extends Model
{
    use HasFactory;
    public function category_name()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static function saveData($post)
    {
        try {
            $dataArray = [
                'name' => $post['product_name'],
                'description' => $post['description'],
                'price' => $post['price'],
                'stock_quantity' => $post['stock_quantity'],
                'color' => $post['color'],
                'size' => $post['size'],
                'material' => $post['material'],
                'category_id' => $post['category_id'],
            ];
            if (!empty($post['image'])) {
                $fileName = Common::uploadFile('product', $post['image']);
                if (!$fileName) {
                    return false;
                }
                $dataArray['image'] = $fileName;
            }
            if (!empty($post['id'])) {
                $dataArray['updated_at'] = Carbon::now();
                if (!Product::where('id', $post['id'])->update($dataArray)) {
                    throw new Exception("Couldn't update Records", 1);
                }
            } else {
                $dataArray['created_at'] = Carbon::now();
                if (!Product::insert($dataArray)) {
                    throw new Exception("Couldn't Save Records", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    // List
    public static function list($post)
    {
        try {
            $get = $post;
            $sorting = !empty($get['order'][0]['dir']) ? $get['order'][0]['dir'] : 'asc';
            $orderby = " order_number " . $sorting . "";
            if (!empty($get['order'][0]['column']) && $get['order'][0]['column'] == 6) {
                $orderby = " order_number " . $sorting . "";
            }
            foreach ($get['columns'] as $key => $value) {
                $get['columns'][$key]['search']['value'] = trim(strtolower(htmlspecialchars($value['search']['value'], ENT_QUOTES)));
            }
            $cond = " status = 'Y' ";
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
            $query = Product::with('category_name')->selectRaw("(SELECT COUNT(*) FROM products) AS totalrecs, id, name, description, image,price, category_id,color,size,material,stock_quantity")
                ->whereRaw($cond);
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
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function restoreData($post)
    {
        try {
            $updateArray = [
                'status' => 'Y',
                'updated_at' => Carbon::now(),
            ];
            if (!Product::where(['id' => $post['id']])->update($updateArray)) {
                throw new Exception("Couldn't Restore Data. Please try again", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function deleteData($post)
    {
        try {
            if ($post['type'] === "trashed") {
                if (!empty($post['id'])) {
                    $data = Product::where('id', $post['id'])
                        ->where('status', 'N')->first();
                    if (!$data->delete()) {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }
            } else {
                $courseId = $post['id'];
                $checkCaseforProgramOverview = ProgramOverview::where('course_id', $courseId)->first();
                if (!empty($checkCaseforProgramOverview)) {
                    throw new Exception("This Course is associated with overview.", 1);
                }
                $updateArray = [
                    'status' => 'N'
                ];
                if (!empty($post['id'])) {
                    $updateArray['updated_at'] = Carbon::now();
                    if (!Product::where('id', $courseId)->update($updateArray)) {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
