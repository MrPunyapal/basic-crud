<?php

declare(strict_types=1);

use App\Support\FileUploaderFromUrl;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

test('invoke returns uploaded file', function () {
    Http::fake([
        'example.com/*' => Http::response('file content', 200, ['Content-Type' => 'text/plain']),
    ]);

    $uploader = new FileUploaderFromUrl;
    $uploadedFile = $uploader('http://example.com/file.txt');

    expect($uploadedFile)->toBeInstanceOf(UploadedFile::class);
    expect($uploadedFile->getClientOriginalName())->toBe('file.txt');
    expect($uploadedFile->getClientMimeType())->toBe('text/plain');
    expect(file_get_contents($uploadedFile->getPathname()))->toBe('file content');
});

test('invoke returns null on failed request', function () {
    Http::fake([
        'example.com/*' => Http::response('Not Found', 404),
    ]);

    $uploader = new FileUploaderFromUrl;
    $uploadedFile = $uploader('http://example.com/file.txt');

    expect($uploadedFile)->toBeNull();
});

test('invoke returns null on temp file creation failure', function () {
    Http::fake([
        'example.com/*' => Http::response('file content', 200, ['Content-Type' => 'text/plain']),
    ]);

    $uploader = $this->partialMock(FileUploaderFromUrl::class, function ($mock) {
        $mock->shouldReceive('tempnam')->andReturn(false);
    });

    $uploadedFile = $uploader('http://example.com/file.txt');

    expect($uploadedFile)->toBeNull();
});
