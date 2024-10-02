<?php

namespace App\Models;

use App\Mail\AccountCreatedMail;
use App\Models\Common;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserAccount extends Model
{
    use HasFactory;
    protected $table = 'users';

    public static function saveUser($post)
    {
        try {
            // $password = Str::random(8);
            $insertArray = [
                'email' => $post['email'],
                'password' => bcrypt($post['password']),
                //'password' => $post['password'],
                'name' => strip_tags($post['username']),
                'phone_number' => $post['phone'],
                'address' => $post['address'],
                'gender' => $post['gender'],
            ];
            if (!empty($post['image'])) {
                $fileName = Common::uploadFile('user-account', $post['image']);
                if (!$fileName) {
                    return false;
                }
                $insertArray['image'] = $fileName;
            }
            if (!empty($post['id'])) {
                $insertArray['updated_at'] = Carbon::now();
                if (!UserAccount::where('id', $post['id'])->update($insertArray)) {
                    throw new Exception("Couldn't update record", 1);
                }
                $getLastUserID = $post['id']; // Use the existing ID
            } else {
                $insertArray['created_at'] = Carbon::now();
                if (!UserAccount::insert($insertArray)) {
                    throw new Exception("Could't save record", 1);
                }
            }



            // dd($userRoleInsert);
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
            foreach ($get['columns'] as $key => $value) {
                $get['columns'][$key]['search']['value'] = trim(strtolower(htmlspecialchars($value['search']['value'], ENT_QUOTES)));
            }
            $cond = "status = 'Y' ";
            if (!empty($post['type']) && $post['type'] === "trashed") {
                $cond = " status = 'N'";
            }
            if ($get['columns'][1]['search']['value'])
                $cond .= " and lower(name) like '%" . $get['columns'][1]['search']['value'] . "%'";
            if ($get['columns'][2]['search']['value'])
                $cond .= " and lower(email) like '%" . $get['columns'][2]['search']['value'] . "%'";
            $limit = 15;
            $offset = 0;
            if (!empty($get["length"]) && $get["length"]) {
                $limit = $get['length'];
                $offset = $get["start"];
            }
            $query = User::selectRaw("(SELECT count(*) FROM users) AS totalrecs, id, name, email, mobile_number, address, image")
                ->whereRaw($cond)
                ->whereHas('userrole.role', function ($query) {
                    $query->where('role', '=', 'User');
                })
                ->with('userrole.role'); // eager load the role relationship
            if ($limit > -1) {
                $result = $query->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();
            } else {
                $result = $query->orderBy('id', 'desc')->get();
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

    // delete
    public static function deleteData($post)
    {
        try {
            if ($post['type'] === "trashed") {
                $filepath = storage_path('app/public/user-account/');
                // Getting details 
                $userAccount = User::where('id', $post['id'])->first();
                // Deleting the image if it exists
                if (!empty($userAccount->image)) {
                    $previousImagePath = $filepath . $userAccount->image;
                    if (file_exists($previousImagePath)) {
                        unlink($previousImagePath);
                    }
                }
                if (!DB::table('user_roles')->where('user_id', $post['id'])->delete()) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
                if (!$userAccount->delete()) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            } else {
                if (!User::where(['id' => $post['id']])->update(['status' => 'N', 'updated_at' => Carbon::now()])) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function regenerateData($post)
    {
        try {
            $updateArray = [
                'status' => 'Y',
                'updated_at' => Carbon::now(),
            ];
            if (!User::where(['id' => $post['id']])->update($updateArray)) {
                throw new Exception("Couldn't Regenerate Data. Please try again", 1);
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
