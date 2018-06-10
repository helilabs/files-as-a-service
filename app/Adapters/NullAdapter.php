<?php

namespace App\Adapters\Files;

class NullAdapter extends BaseAdapter{

    public function stream()
    {
        return response()->json(
            ['meta' => generate_meta('failure', 'Can\'t find the right adapter')],
            400
        );
    }
}