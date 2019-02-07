<?php

namespace App\Http\Controllers\My\Misc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceController extends Controller{
	
	protected function cleanUploadGarbages(){
		$offset = (60*15);
		
		// grab the cache files
		$d = \Storage::files('upload');
		
		foreach($d as $key=>$files){
			$fileName = explode( '_', basename($files) );
			$old = (int)$fileName[0];
			if ($old+$offset <= time()){
				\Storage::delete($files);
			}
		}
	}	
	
	protected function validateFileSize(Request $request){
		$maxFileSize = $request->upload_max_size;
		if ( $request->upload_file->getSize()>$maxFileSize ){
			return \Response::json([
				'code'=>412, 
				'clientRequestId'=>$request->clientRequestId,
				'message'=> str_replace(
					[':bytes',':megabytes'], 
					[$maxFileSize, floor($maxFileSize/1000000)], 
					trans('my/misc/upload.errors.allowedFileSize')
				)
			], 412);
		}
		return true;
	}
	
	protected function validateMime(Request $request){
		$mime = $request->upload_file->getMimeType();
		if ( !str_contains($request->upload_mime, $mime) ){
			return \Response::json([
				'code'=>415, 
				'clientRequestId'=>$request->clientRequestId,
				'message'=> str_replace(':attribute', str_replace(',',', ',$request->upload_file), trans('my/misc/upload.errors.allowedExtension')),
				'mime'=>$mime,
			], 415);
		}
		return true;
	}
	
    public function upload(Request $request){
		$responseError = [
			'code'=>'500', 
			'clientRequestId'=>$request->clientRequestId,
			'message'=> trans('my/misc/upload.errors.serverError')
		];
		
		try{			
			$this->cleanUploadGarbages();	//cleanup
			
			//validate mime, error response 415
			$validateMime = $this->validateMime($request);
			if ( $validateMime instanceof \Response ) return $validateMime;
			
			//validate file size, error response 412
			$validateFileSize = $this->validateFileSize($request);
			if ( $validateFileSize instanceof \Response ) return $validateFileSize;
			
			//save
			$dir = 'upload';
			$file = $request->upload_file;
			$file_name = time().'_'.$file->getClientOriginalName();
			$file->storeAs($dir, $file_name);
			if ( \Storage::exists($dir.'/'.$file_name) ){
				return \Response::json([
					'code'=>200,
					'clientRequestId'=>$request->clientRequestId,
					'info'=>[
						'name'=>$request->upload_file->getClientOriginalName(),
						'ext'=>$request->upload_file->extension(),
						'size'=>$request->upload_file->getClientSize(),
						'mime'=>$request->upload_file->getMimeType(),
					],
					'remote'=> [
						'disk'=>'local',
						'path'=>$dir.'/'.$file_name,
						'base64'=>base64_encode(\Storage::get($dir.'/'.$file_name)),
					],
				], 200);
			}
		}
		catch(\Exception $e){}
		
		return \Response::json($responseError,500);
	}
	
	public function download(){
		
	}
}
