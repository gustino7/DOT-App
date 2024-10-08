<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecturer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Fungsi ini digunakan untuk menampilkan detail Course
     * berdasarkan ID.
     * 
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        try {
            $course = Course::find($id);
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Course',
                'data' => $course,
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => "Error to Find a Course",
            ], 400);
        }
    }

    /**
     * Menampilkan daftar Course, dengan opsi pencarian apabila
     * disertai parameter 'search'.
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getAll(Request $request)
    {
        $search = $request->input('search');

        try {
            if ($search) {
                $courses = Course::where('name', 'LIKE', "%$search%")->get();
            } else {
                $courses = Course::oldest("created_at")->get();
            }
            return response()->json([
                'success' => true,
                'message' => 'List Data Course',
                'data' => $courses,
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => "Can't Find List Data Course",
            ], 400);
        }
    }

    /**
     * Menyimpan data Course baru
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'credits' => 'required|integer|digits:1',
            'class' => 'required|string|max:2',
            'lecturerId' => 'exists:lecturers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 400);
        }

        try {
            $course = Course::create([
                'name' => $request->name,
                'credits' => $request->credits,
                'class' => $request->class,
                'lecturerId' => $request->lecturerId,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Course Stored',
                'data' => $course,
            ], 201);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed Store Course',
            ], 400);
        }
    }

    /**
     * Memperbarui data Course berdasarkan ID.
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'credits' => 'required|digits:1',
            'class' => 'required|string|max:2',
            'lecturerId' => 'exists:lecturers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 400);
        }

        try {
            $course = Course::findOrFail($id);
            $course->update([
                'name' => $request->name,
                'credits' => $request->credits,
                'class' => $request->class,
                'lecturerId' => $request->lecturerId,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Course Updated',
                'data' => $course
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => "Failed Updated Course",
            ], 400);
        }
    }

    /**
     * Menghapus Course berdasarkan ID.
     * 
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();
            return response()->json([
                'success' => true,
                'message' => 'Course Deleted',
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed Deleted Course',
            ], 404);
        }
    }
}
