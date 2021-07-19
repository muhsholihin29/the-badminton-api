<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class ApiNoteController extends Controller
{
	function index(Request $request){
		$notes = \App\Models\Note::where('androidId', $request->androidId)->get();

			if (!$notes) {
				return response()->json([
					'code' => Response::HTTP_FORBIDDEN, 
					'message' => 'Gagal '
				]);
			}
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'Success'
			];
		
		return response()->json(['meta' => $meta, 'data' => $notes]);
	}

	function insertNote(Request $request)
	{
			$dataNote = [
				'title' => $request->title,
				'note' => $request->note,
				'androidId' => $request->androidId
			];

			$insert = \App\Models\Note::create($dataNote);

			if (!$insert) {
				return response()->json([
					'code' => Response::HTTP_FORBIDDEN, 
					'message' => 'Gagal disimpan'
				]);
			}
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'Success'
			];
		
		return response()->json(['meta' => $meta]);
	}

	function deleteNote(Request $request)
	{
			$delete = \App\Models\Note::where('id', $request->id)->delete();
			if (!$delete) {
				return response()->json([
					'code' => Response::HTTP_FORBIDDEN, 
					'message' => 'Gagal dihapus'
				]);
			}
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'Success'
			];
		
		return response()->json(['meta' => $meta]);
	}
}
