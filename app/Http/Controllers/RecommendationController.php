<?php

namespace App\Http\Controllers;

use App\Models\AssociationRule;
use App\Models\Menu;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function getRecommendations(Request $request)
    {
        $productIds = $request->input('product_ids', []);
        
        if (empty($productIds)) {
            return response()->json([]);
        }

        // Cari rekomendasi dengan confidence dan lift tertinggi
        $rules = AssociationRule::whereIn('antecedent_id', $productIds)
            ->whereNotIn('consequent_id', $productIds) // Jangan rekomendasikan yang sudah di keranjang
            ->orderBy('confidence', 'desc')
            ->orderBy('lift', 'desc')
            ->with('consequent')
            ->get();
            
        // Ambil menu yang direkomendasikan, pastikan unik, limit 3
        $recommendations = $rules->unique('consequent_id')->take(3)->values();

        return response()->json($recommendations);
    }
}
