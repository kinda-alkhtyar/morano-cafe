<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageContent extends Model
{
    protected $guarded = ['id'];
    protected function casts(): array { return ['hours' => 'array', 'hours_provisional' => 'boolean']; }
}
