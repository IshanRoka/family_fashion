<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\BackPanel\Faq;
use Exception;

use Illuminate\Database\QueryException;

class Common extends Model
{
    use HasFactory;


    public static function uploadFile($location, $file)
    {
        try {
            $extension = $file->getClientOriginalExtension();
            if (!in_array($extension, ['png', 'jpg', 'jpeg']))
                throw new Exception('File format is not matched, upload in list (PNG/JPG/JPEG', 1);

            $tempName = Str::random(30) . '-' . time() . '.' . $extension;
            $storeFile = $file->storeAs($location, $tempName, 'public');

            if (empty($storeFile))
                return false;

            return $tempName;
        } catch (Exception $e) {
            throw $e;
        }
    }




    public static function deleteProgramRelation($post, $class)
    {
        try {
            if ($post['type'] === "trashed") {
                if ($post['id']) {
                    $categoryId = $post['id'];
                    $checkCaseforProduct = Product::where('category_id', $categoryId)->first();
                    if (!empty($checkCaseforProduct)) {
                        throw new Exception("This category is associated with product.", 1);
                    }
                }
                $postInstance = $class->findOrFail($post['id']);
                if (!$postInstance->delete()) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            } else {
                if (!$class::where(['id' => $post['id']])->update(['status' => 'N', 'updated_at' => Carbon::now()])) {
                    throw new Exception("Couldn't Delete Datad. Please try again", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}