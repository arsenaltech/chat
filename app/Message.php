<?php
/**
 * Created by PhpStorm.
 * User: shabbir
 * Date: 4/6/17
 * Time: 6:30 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function from()
    {
        return $this->belongsTo(User::class, 'from_id', 'id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_id', 'id');
    }
}