<?php

namespace App\Http\Controllers;

use App\File;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FilesController extends Controller
{

	public function store(Request $request)
	{
		$file = $request->file('file');

		if(!$file->isValid()){
			return response()->json(['meta' => generate_meta('failure', 'File is not valid')], 400);
		}

		$uuid = Uuid::uuid1();
		$now = Carbon::now();

		$model = File::create([
			'mime_type' => $file->getMimeType(),
			'uuid' => File::encodeUuid($uuid)
		]);

		$file->move(base_path("storage/uploads/{$now->format('Y')}/{$now->format('m')}"), $uuid->toString());

		return response()->json([
			'data' => [
				'uuid' => $model->uuid_text
			],
			'meta' => generate_meta('success')
		], 200);
	}

	public function show(Request $request)
	{
		$file = File::withUuid(request($request, 'uuid'))->firstOrFail();

		return $file->getAdapter($request)->stream();
	}
}
