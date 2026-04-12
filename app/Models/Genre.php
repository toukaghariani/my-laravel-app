<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Content;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
  public function contents()
{
    return $this->belongsToMany(Content::class, 'contentgenres');
}
}
