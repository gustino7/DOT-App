<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LecturerController extends Controller
{
    /**
     * Menampilkan detail Lecturer berdasarkan ID
     * 
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        try {
            $lecturer = Lecturer::find($id);
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Lecturer',
                'data' => $lecturer,
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => "Can't Find a Lecturer",
            ], 400);
        }
    }

    /**
     * Menampilkan daftar Lecturer dengan opsi pencarian apabila
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
                $lecturers = Lecturer::where('name', 'LIKE', "%$search%")->get();
            } else {
                $lecturers = Lecturer::oldest("created_at")->get();
            }
            return response()->json([
                'success' => true,
                'message' => 'List Data Lecturers',
                'data' => $lecturers,
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => "Can't Find List Data Lecturers",
            ], 400);
        }
    }

    /**
     * Menyimpan data Lecturer baru.
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
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

        try {
            $lecturer = Lecturer::create([
                'name' => $request->name,
                'registNumber' => $request->registNumber,
                'phone' => $request->phone,
                'birth' => $request->birth,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Lecturer Stored',
                'data' => $lecturer,
            ], 201);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed Store Lecturer',
            ], 400);
        }
    }

    /**
     * Memperbarui data Lecturer yang ada berdasarkan ID
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
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
        try {
            $lecturer = Lecturer::findOrFail($id);
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
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => "Failed Updated Lecturer",
            ], 400);
        }

    }

    /**
     * Menghapus data Lecturer yang ada berdasarkan ID.
     * 
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            $lecturer = Lecturer::findOrFail($id);
            $lecturer->delete();
            return response()->json([
                'success' => true,
                'message' => 'Lecturer Deleted',
            ], 200);

        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed Deleted Lecturer',
            ], 404);
        }
    }
}
