<?php

namespace App\Http\Controllers;

use App\Services\PersonaExpertService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonaQuizController extends Controller
{
    public function index(PersonaExpertService $service): View
    {
        $questions = $service->getQuestions();

        return view('storefront.persona.index', [
            'questions' => $questions,
            'totalQuestions' => count($questions),
        ]);
    }

    public function calculate(Request $request, PersonaExpertService $service): JsonResponse
    {
        $request->validate([
            'answers' => 'required|array|min:5',
            'answers.*' => 'required|string|max:5',
        ]);

        $result = $service->calculatePersona($request->input('answers'));

        // Transform products for JSON
        $products = $result['products']->map(function ($product) {
            $firstImage = $product->images->first();
            $imageUrl = null;
            if ($firstImage) {
                $url = $firstImage->image_url;
                $imageUrl = str_starts_with($url, 'http') || str_starts_with($url, '/')
                    ? $url
                    : asset('storage/' . ltrim($url, '/'));
            }

            $variant = $product->variants->first();

            return [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand->name ?? 'Unknown',
                'category' => $product->category->name ?? '',
                'description' => \Illuminate\Support\Str::limit($product->description, 100),
                'scents' => $product->scents->pluck('name')->toArray(),
                'price' => $variant ? 'Rp ' . number_format($variant->price, 0, ',', '.') : '-',
                'image' => $imageUrl,
                'url' => "/product/{$product->id}",
                'in_stock' => $variant && ($variant->stock ?? 0) > 0,
            ];
        });

        return response()->json([
            'success' => true,
            'persona' => $result['persona'],
            'products' => $products->values(),
        ]);
    }
}
