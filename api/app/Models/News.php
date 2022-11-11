<?php

namespace App\Models;

use App\Models\Enums\Books\FileType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes, HasCodeGenerator;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'categories_id',
        'body',
    ];

    protected $hidden = [
        'id',
        'categories_id',
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    protected $appends = [
        'registration_date',
    ];

    //Mutators & Accessors
    public function getRegistrationDateAttribute(){
        return $this->created_at->format('d/m/Y H:i');
    }

    //Relationships
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
