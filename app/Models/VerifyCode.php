<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VerifyCode extends Model
{
    protected $fillable = ['mobile', 'code'];

    protected $dates = ['created_at', 'updated_at'];

    public function getExpiredAtAttribute() {
      return Carbon::parse($this->attributes['created_at'])->addMinutes(5);
    }

    public function getIsExpiredAttribute() {
      return $this->expired_at->isPast();
    }

    public function scopeNotExpired($q) {
      return $q->where('created_at', '>', Carbon::now()->addMinutes(-5)->toDateTimeString());
    }

    public function scopeWithinLastMinute($q) {
      return $q->where('created_at', '>', Carbon::now()->addMinutes(-1)->toDateTimeString());
    }
}
