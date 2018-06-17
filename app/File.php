<?php
namespace App;

use Illuminate\Http\Request;
use App\Adapters\Files\NullAdapter;
use App\Adapters\Files\ImageAdapter;
use Spatie\BinaryUuid\HasBinaryUuid;
use Illuminate\Database\Eloquent\Model;

Class File extends Model{

    use HasBinaryUuid;

    public $fillable = [
        'mime_type', 'uuid'
    ];

    /*----------------------------------------------------
    * Methods
    --------------------------------------------------- */
    /**
     * get the right handler for the file
     *
     * @param Request $request
     * @return \App\BaseAdapter
     */
    function getAdapter(Request $request){
        if($this->is_image()){
            return new ImageAdapter($request, $this);
        }
        //TODO:: Add placeholder adapter implementation
        return new NullAdapter($request, $this);
    }

    /**
     * Check if current file is an image
     *
     * @return boolean
     */
    public function is_image()
    {
        $image_mime_types = [
            'image/png', 'image/gif', 'image/jpg', 'image/jpeg'
        ];

        if(in_array($this->mime_type, $image_mime_types)){
            return true;
        }

        return false;
    }

    /*----------------------------------------------------
    * Attributes
    --------------------------------------------------- */
    public function getPathAttribute()
    {
        return base_path("storage/uploads/{$this->created_at->format('Y')}/{$this->created_at->format('m')}/{$this->uuid_text}");
    }
}