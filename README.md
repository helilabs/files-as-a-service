# Files MicroService.
This project is a simple micro service that can be integrated with your app to provide upload and retrieve files functionalities. (Files as a service).

## Introduction
This project was built as part of my **micro services project** where i turn common modules to simple micro-services that easily integrated with any app.

The project is well-coded, well-tested and maintained to be simple and fast so it's easy to customize it the way you need.

## Usage
0. currently this micro-service supports only images but with plans to support other types of files.
1. clone this repo to your server.
2. use `post /api/files` to upload new file and it will respond with uuid.
```php
$response = $this->call('post','api/files', [], [],[
			'file' => UploadedFile::fake()->image('image.jpg')
		]);
```
3. use `get api/files/{uuid}` to get image
    1. response of this requests is cached for better performance
    2. add query string `s` to resize image as follows `get api/files/{uuid}?s=100`
```php
$res = $this->get("api/files/{$uuid}");
```

## Contributors
1. [Mohammed Manssour](https://mohammedmanssour.me)