<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LecturerController extends Controller
{
    public function get($id)
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'success' => false,
                'message' => "Please Login First",
            ], 401);
        }

        $lecturer = Lecturer::find($id);

        if ($lecturer) {

            return response()->json([
                'success' => true,
                'message' => 'Detail Data Lecturer',
                'data' => $lecturer,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "Can't Find a Lecturer",
        ], 400);

    }

    public function getAll(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Please authenticate with a valid token.',
            ], 401);
        }

        $search = $request->input('search');

        if ($search) {
            $lecturers = Lecturer::where('name', 'LIKE', "%$search%")->get();
        } else {
            $lecturers = Lecturer::oldest("created_at")->get();
        }

        if ($lecturers) {
            return response()->json([
                'success' => true,
                'message' => 'List Data Lecturers',
                'data' => $lecturers,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "Can't Find List Data Lecturers",
        ], 400);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'registNumber' => 'required|string',
            'phone' => 'required|string|max:15',
            'birth' => 'required|date_format:Y-n-j'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 400);
        }

        $lecturer = Lecturer::create([
            'name' => $request->name,
            'registNumber' => $request->registNumber,
            'phone' => $request->phone,
            'birth' => $request->birth,
        ]);

        if ($lecturer) {

            return response()->json([
                'success' => true,
                'message' => 'Lecturer Stored',
                'data' => $lecturer,
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed Store Lecturer',
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'registNumber' => 'required|string',
            'phone' => 'required|string|max:15',
            'birth' => 'required|date_format:Y-n-j'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 400);
        }

        $lecturer = Lecturer::find($id);

        if ($lecturer) {

            $lecturer->update([
                'name' => $request->name,
                'registNumber' => $request->registNumber,
                'phone' => $request->phone,
                'birth' => $request->birth,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lecturer Updated',
                'data' => $lecturer
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "Failed Updated Lecturer",
        ], 400);
    }

    public function delete($id)
    {
        $lecturer = Lecturer::find($id);

        if ($lecturer) {

            $lecturer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Lecturer Deleted',
            ], 200);

        }

        return response()->json([
            'success' => false,
            'message' => 'Failed Deleted Lecturer',
        ], 404);
    }
}
