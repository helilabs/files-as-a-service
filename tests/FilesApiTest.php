<?php

use App\File;
use Illuminate\Http\UploadedFile;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class FilesApiTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function can_upload_new_image()
	{

		$response = $this->call('post','api/files', [], [],[
			'file' => UploadedFile::fake()->image('image.jpg')
		]);

		$this->seeStatusCode(200);
		$this->seeJson([
			'meta' => generate_meta('success')
		]);

		$this->assertArrayHasKey('uuid', json_decode($response->getContent(), true)['data']);

		$this->seeInDatabase('files', [
			'mime_type' => 'image/jpeg'
		]);

		// die();
	}

	/** @test */
	public function can_get_uploaded_images()
	{
		$file = File::create([
			'mime_type' => 'image/jpeg'
		]);

		$this->generate_image($file);

		$res = $this->get("api/files/{$file->uuid_text}");

		$this->seeStatusCode(200);
	}

	private function generate_image(File $file, $width = 800, $height = 600)
	{

		$fileHandler = fopen($file->path, 'w');

		ob_start();
		imagepng(imagecreatetruecolor($width, $height));
		fwrite($fileHandler, ob_get_clean());

		fclose($fileHandler);
	}
}
