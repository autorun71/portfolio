<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Music
 *
 * @property int $id
 * @property string $name
 * @property string $artist
 * @property string $link
 * @property string $duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Music newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Music newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Music query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Music whereArtist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Music whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Music whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Music whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Music whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Music whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Music whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Music extends Model
{
    //
}
