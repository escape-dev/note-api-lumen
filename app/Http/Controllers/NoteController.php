<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $notes = Note::all();

        return response()->json([
            'success' => true,
            'data' => $notes
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $note = Note::create([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'body' => $request->body,
        ]);

        return response()->json([
            'success' => true,
            'data' => $note,
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $note = Note::firstWhere('id', $id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $note,
        ]);
    }

    public function update(Request $request, $id)
    {
        $note = Note::firstWhere('id', $id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $note->update([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'body' => $request->body,
        ]);

        return response()->json([
            'success' => true,
            'data' => $note
        ]);
    }

    public function destroy($id)
    {
        $note = Note::firstWhere('id', $id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $note->delete();

        return response()->json([
            'status' => true,
            'message' => 'deleted successfully'
        ]);
    }
}
