<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationRule extends Model
{
    use HasFactory;
    
    protected $fillable = ['antecedent_id', 'consequent_id', 'support', 'confidence', 'lift'];
    
    public function antecedent()
    {
        return $this->belongsTo(Menu::class, 'antecedent_id');
    }
    
    public function consequent()
    {
        return $this->belongsTo(Menu::class, 'consequent_id');
    }
}
