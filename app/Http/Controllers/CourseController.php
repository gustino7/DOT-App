<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function get($id)
    {
        $course = Course::find($id);

        if ($course) {

            return response()->json([
                'success' => true,
                'message' => 'Detail Data Course',
                'data' => $course,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "Can't Find a Course",
        ], 400);

    }

    public function getAll(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $courses = Course::where('name', 'LIKE', "%$search%")->get();
        } else {
            $courses = Course::oldest("created_at")->get();
        }

        if ($courses) {
            return response()->json([
                'success' => true,
                'message' => 'List Data Course',
                'data' => $courses,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "Can't Find List Data Course",
        ], 400);

    }

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

        $course = Course::create([
            'name' => $request->name,
            'credits' => $request->credits,
            'class' => $request->class,
            'lecturerId' => $request->lecturerId,
        ]);

        if ($course) {

            return response()->json([
                'success' => true,
                'message' => 'Course Stored',
                'data' => $course,
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed Store Course',
        ], 400);
    }

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

        $course = Course::find($id);

        if ($course) {

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
        }

        return response()->json([
            'success' => false,
            'message' => "Failed Updated Course",
        ], 400);
    }

    public function delete($id)
    {
        $course = Course::find($id);

        if ($course) {

            $course->delete();

            return response()->json([
                'success' => true,
                'message' => 'Course Deleted',
            ], 200);

        }

        return response()->json([
            'success' => false,
            'message' => 'Failed Deleted Course',
        ], 404);
    }
}
