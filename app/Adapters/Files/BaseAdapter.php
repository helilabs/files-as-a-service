<?php

namespace App\Adapters\Files;

use App\File;
use Illuminate\Http\Request;

Abstract Class BaseAdapter{

    protected $request;

    /**
     * Image that will be streamed
     *
     * @var \App\File
     */
    protected $file;

    public function __construct( Request $request, File $file ){
        $this->request = $request;
        $this->file = $file;
    }

    abstract public function stream();
}