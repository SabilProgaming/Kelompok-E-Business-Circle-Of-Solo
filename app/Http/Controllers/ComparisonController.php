<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\PersonaExpertService;
use Illuminate\Http\Request;

class ComparisonController extends Controller
{
    protected $personaService;

    public function __construct(PersonaExpertService $personaService)
    {
        $this->personaService = $personaService;
    }

    public function index(Request $request)
    {
        $allProducts = Product::with(['brand', 'variants'])->get();
        
        $product1 = null;
        $product2 = null;
        $verdict = null;

        if ($request->has('p1') && $request->p1 != '') {
            $product1 = Product::with(['brand', 'category', 'scents', 'variants', 'images'])->find($request->p1);
        }
        
        if ($request->has('p2') && $request->p2 != '') {
            $product2 = Product::with(['brand', 'category', 'scents', 'variants', 'images'])->find($request->p2);
        }

        if ($product1 && $product2) {
            $verdict = $this->calculateVerdict($product1, $product2);
        }

        return view('storefront.comparison.index', compact('allProducts', 'product1', 'product2', 'verdict'));
    }

    private function calculateVerdict($p1, $p2)
    {
        $personas = $this->personaService->getAllPersonas();
        $results = [];

        foreach ($personas as $key => $persona) {
            $affinity = $persona['scent_affinity'];
            
            // Check p1 match
            $p1Match = $p1->scents->whereIn('name', $affinity)->count();
            $p1Match += (collect([$p1->top_notes, $p1->middle_notes, $p1->base_notes])->filter(function($note) use ($affinity) {
                foreach ($affinity as $aff) {
                    if (stripos($note, $aff) !== false) return true;
                }
                return false;
            })->count());

            // Check p2 match
            $p2Match = $p2->scents->whereIn('name', $affinity)->count();
            $p2Match += (collect([$p2->top_notes, $p2->middle_notes, $p2->base_notes])->filter(function($note) use ($affinity) {
                foreach ($affinity as $aff) {
                    if (stripos($note, $aff) !== false) return true;
                }
                return false;
            })->count());

            if ($p1Match > $p2Match) {
                $results[$key] = ['winner' => 1, 'score' => $p1Match, 'name' => $persona['name'], 'emoji' => $persona['emoji']];
            } elseif ($p2Match > $p1Match) {
                $results[$key] = ['winner' => 2, 'score' => $p2Match, 'name' => $persona['name'], 'emoji' => $persona['emoji']];
            }
        }

        return $results;
    }
}
