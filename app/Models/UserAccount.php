<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserAccount extends Model
{
    use HasFactory;

    protected $table = 'users';

    public static function saveUser($post)
    {
        try {
            $insertArray = [
                'email' => $post['email'],
                'password' => bcrypt($post['password']),
                'username' => strip_tags($post['username']),
                'phone' => $post['phone'],
                'address' => $post['address'],
                'gender' => $post['gender'],
            ];
            if (!empty($post['id'])) {
                $insertArray['updated_at'] = Carbon::now();
                if (!UserAccount::where('id', $post['id'])->update($insertArray)) {
                    throw new Exception("Couldn't update record", 1);
                }
            } else {
                $insertArray['created_at'] = Carbon::now();
                if (!UserAccount::insert($insertArray)) {
                    dd('yes');
                    throw new Exception("Could't save record", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

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
            $query = User::selectRaw("(SELECT COUNT(*) FROM users) AS totalrecs, id, username, email, address, phone");
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
}
