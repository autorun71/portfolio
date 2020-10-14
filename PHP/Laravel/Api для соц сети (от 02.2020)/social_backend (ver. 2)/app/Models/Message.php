<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Message
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $from
 * @property int $to
 * @property string $text
 * @property int $edit_status
 * @property int $read_status
 * @property int $show_to
 * @property int $show_from
 * @property int $enable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereEditStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereReadStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereShowFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereShowTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Message extends Model
{
    //
}
