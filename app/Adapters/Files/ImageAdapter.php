<?php

namespace App\Adapters\Files;

Class ImageAdapter extends BaseAdapter{

    public function stream()
    {
        return response($this->getProcessedImage())
                    ->header('Content-Type', 'image/png');
    }

    protected function getProcessedImage(){
        return app('imageManager')->cache(function ($builder) {
            $this->processImage(
                $builder->make(
                    $this->file->path
                )
            );
        });
    }

    protected function processImage($builder)
    {
        return $builder->resize(null, $this->getRequestedSize(), function ($constraint) {
            $constraint->aspectRatio();
        })
        ->encode('png');
    }

    protected function getRequestedSize()
    {
        return max(
                    min(
                        get('s', 100), 800
                    ), 10
                );
    }
}