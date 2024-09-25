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



    // permanent Delete data
    public static function deleteRelationData($post, $class, $filepath)
    {
        try {
            $query = $class::query();
            if ($post['type'] === "trashed") {

                if (method_exists($class, 'images')) {
                    $query->with('images');
                }

                $postInstance = $query->findOrFail($post['id']);


                //delete relation -start
                // Delete related images
                if ($postInstance->images) {
                    foreach ($postInstance->images as $image) {

                        if (!$image->delete()) {
                            throw new Exception("Couldn't Delete Data. Please try again", 1);
                        }

                        if (file_exists($filepath)) {
                            unlink($filepath . '/' . $image->image);
                        } else {
                            throw new Exception("Couldn't Delete Data. Please try again", 1);
                        }
                    }
                }

                // Delete related teamCategory
                if ($postInstance->teamCategory) {
                    if (!$postInstance->delete()) {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }
                //delete relation -end


                // Delete the main Gallery instance
                if ($postInstance->image) {
                    if (file_exists($filepath . '/' . $postInstance->image)) {
                        unlink($filepath . '/' . $postInstance->image);
                    }
                }

                if (!$postInstance->delete()) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            } else {
                if (!$class::where(['id' => $post['id']])->update(['status' => 'N', 'updated_at' => Carbon::now()])) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function deleteSingleData($post, $class, $filepath)
    {
        try {
            if ($post['type'] === "trashed") {
                $postInstance = $class->findOrFail($post['id']);
                if (!$postInstance->delete()) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
                if ($postInstance->feature_image) {

                    $decodedFeatureImages = json_decode($postInstance->feature_image, true);
                    foreach ($decodedFeatureImages as $image) {

                        if (file_exists($filepath . '/' . $image)) {
                            unlink($filepath . '/' . $image);
                        }
                    }
                }

                if (!empty($postInstance->image)) { // no image case
                    if (file_exists($filepath . '/' . $postInstance->image)) {
                        unlink($filepath . '/' . $postInstance->image);
                    } else {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }

                //apply condition for all delete option like this way
                if (!empty($postInstance->photo)) { // no Photo case 
                    if (file_exists($filepath . '/' . $postInstance->photo)) {
                        unlink($filepath . '/' . $postInstance->photo);
                    } else {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }

                if (!empty($postInstance->file)) { // no file case 
                    if (file_exists($filepath . '/' . $postInstance->file)) {
                        unlink($filepath . '/' . $postInstance->file);
                    } else {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }
            } else {
                if (!$class::where(['id' => $post['id']])->update(['status' => 'N', 'updated_at' => Carbon::now()])) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public static function deleteSingleDataTwoImage($post, $class, $filepath)
    {
        try {
            if ($post['type'] === "trashed") {
                $postInstance = $class->findOrFail($post['id']);
                if (!$postInstance->delete()) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
                if (!empty($filepath)) { // no image case
                    if (file_exists($filepath . '/' . $postInstance->thumbnail_image)) {
                        unlink($filepath . '/' . $postInstance->thumbnail_image);
                    }
                    if (file_exists($filepath . '/' . $postInstance->feature_image)) {
                        unlink($filepath . '/' . $postInstance->feature_image);
                    } else {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }
            } else {
                if (!$class::where(['id' => $post['id']])->update(['status' => 'N', 'updated_at' => Carbon::now()])) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public static function deleteDataFileDoesnotExists($post, $class)
    {
        try {
            if ($post['type'] === "trashed") {
                $postInstance = $class->findOrFail($post['id']);
                if (!$postInstance->delete()) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            } else {
                if (!$class::where(['id' => $post['id']])->update(['status' => 'N', 'updated_at' => Carbon::now()])) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function deleteCoureRelation($post, $class, $filepath)
    {
        try {
            if ($post['type'] === "trashed") {
                if ($post['id']) {
                    $course_id = $post['id'];
                    $checkCaseforCourse = ProgramOverview::where('course_id', $course_id)->first();
                    if (!empty($checkCaseforCourse)) {
                        throw new Exception("This course is associated with overview.", 1);
                    }
                }
                $postInstance = $class->findOrFail($post['id']);
                if (!$postInstance->delete()) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
                if (!empty($postInstance->image)) {
                    if (file_exists($filepath . '/' . $postInstance->image)) {
                        unlink($filepath . '/' . $postInstance->image);
                    } else {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }
                if (!empty($postInstance->photo)) {
                    if (file_exists($filepath . '/' . $postInstance->photo)) {
                        unlink($filepath . '/' . $postInstance->photo);
                    } else {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }
                if (!empty($postInstance->file)) { // no file case 
                    if (file_exists($filepath . '/' . $postInstance->file)) {
                        unlink($filepath . '/' . $postInstance->file);
                    } else {
                        throw new Exception("Couldn't Delete Data. Please try again", 1);
                    }
                }
            } else {
                if (!$class::where(['id' => $post['id']])->update(['status' => 'N', 'updated_at' => Carbon::now()])) {
                    throw new Exception("Couldn't Delete Data. Please try again", 1);
                }
            }
            return true;
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
