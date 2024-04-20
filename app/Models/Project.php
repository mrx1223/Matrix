<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ["name", "description"];

    public function projectCost(): HasMany
    {
        return $this->hasMany(ProjectCost::class, 'project_id', 'id');
    }
}
