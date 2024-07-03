<?php

namespace App\Models;

use App\Traits\HasUlid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory, HasUlid;

    public $fillable = [
        'title',
        'content',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function createdAt(): Attribute
    {
        return new Attribute(
            //accessor to transform the value when it is accessed
            get: fn ($value) => Carbon::parse($value)->diffForHumans(),
            //you can also use set to mutate the value
            // set : fn($value) =>
        );
    }
}
