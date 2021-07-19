<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class ApiVideoController extends Controller
{
	function index(){
		$videos = \App\Models\Video::get();

			if (!$videos) {
				return response()->json([
					'code' => Response::HTTP_FORBIDDEN, 
					'message' => 'fail - can\'t read db'
				]);
			}
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'success'
			];
		
		return response()->json(['meta' => $meta, 'data' => $videos]);
	}

	function getVideo(Request $request){
		$videos = \App\Models\Video::where('id', $request->id)->first();
		$destination_path = public_path('/video');
		$videos->videoUrl = $destination_path.'/'.$videos->videoUrl;
		$videos->thumbnailUrl = $destination_path.'/'.$videos->thumbnailUrl;
			if (!$videos) {
				return response()->json([
					'code' => Response::HTTP_FORBIDDEN, 
					'message' => 'fail - can\'t read db'
				]);
			}
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'success'
			];
		
		return response()->json(['meta' => $meta, 'data' => $videos]);
	}

	function insertVideo(Request $request)
	{
		
		if ($request->hasFile('thumbnail')) {
			$thumbnail = $request->file('thumbnail');  
			$video = $request->file('video');  
			$destination_path = public_path('/video');

			$dataComment
			 = [
				'name' => $request->name,
				'title' => $request->title,
				'overview' => $request->overview,
				'videoUrl' => "",
				'thumbnailUrl' => "",
				'androidId' => $request->androidId
			];

				$insertWithId = \App\Models\Video::create($dataComment
				)->id;
				$nameThumbnail = 'thumbnail-'.$insertWithId.".".$thumbnail->getClientOriginalExtension();
				$nameVideo = 'video-'.$insertWithId.".".$video->getClientOriginalExtension();
				$insertWithId = \App\Models\Video::where('id', $insertWithId)->update(['thumbnailUrl' => $nameThumbnail, 'videoUrl' => $nameVideo]);
			

			$thumbnail->move($destination_path, $nameThumbnail);
			$video->move($destination_path, $nameVideo);
			
			if (!$insertWithId) {
				return response()->json([
					'code' => Response::HTTP_OK, 
					'message' => 'fail - db can\'t save'
				]);
			}
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'success'
			];
		} else {
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'fail - no file'
			];
		}
		
		return response()->json(['meta' => $meta]);
	}

	function deleteVideo(Request $request)
	{
		$destination_path = public_path('/video');		
			$video = \App\Models\Video::where('id', $request->id)->first();
			unlink($destination_path.'/'.$video->videoUrl);
			unlink($destination_path.'/'.$video->thumbnailUrl);
			$delete = \App\Models\Video::where('id', $request->id)->delete();
			if (!$video) {
				return response()->json([
					'status' => Response::HTTP_OK, 
					'message' => 'fail - can\'t delete'
				]);
			}
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'success'
			];
		
		return response()->json(['meta' => $meta]);
	}

	function insertComment(Request $request)
	{
			$dataComment = [
				'name' => $request->name,
				'comment' => $request->comment,
				'idVideo' => $request->idVideo
			];

			$insert = \App\Models\Comment::create($dataComment);

			
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

	function getComments(Request $request)
	{
			$comments = \App\Models\Comment::where('idVideo', $request->id)->get();

			if (!$comments) {
				return response()->json([
					'code' => Response::HTTP_FORBIDDEN, 
					'message' => 'Gagal '
				]);
			}
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'Success'
			];
		
		return response()->json(['meta' => $meta, 'data' => $comments]);
	}

	function deleteComment(Request $request)
	{
			$delete = \App\Models\Comment::where('id', $request->id)->delete();

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
