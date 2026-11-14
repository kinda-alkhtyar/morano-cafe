<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected function casts(): array { return ['is_available' => 'boolean', 'is_featured' => 'boolean']; }
    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function allergens(): BelongsToMany { return $this->belongsToMany(Allergen::class); }
}
