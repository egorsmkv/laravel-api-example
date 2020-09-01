<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 *
 * @property string $title
 *
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Data\Models
 */
class Article extends Model
{
    public $table = 'articles';

    public function toArray()
    {
        return [
            'id' => $this->id,

            'title' => $this->title,

            'created_at' => $this->created_at ? $this->created_at->format('d.m.Y H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('d.m.Y H:i:s') : null,
        ];
    }
}
