<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;


class ArtistTransformer extends TransformerAbstract
{
    public function transform($model)
    {
        return [
            'id'            => $model->id,
            'albums'        => $model->albums,
            'artist'        => $model->artist,
            'image'         => $model->image,
            'musician_from' => $model->musician_from
        ];
    }
}