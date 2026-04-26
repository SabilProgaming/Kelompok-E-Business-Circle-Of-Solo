<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function home(): View
    {
        return view('storefront.home');
    }

    public function catalog(Request $request): View
    {
        $search = trim((string) $request->string('search'));

        $products = Product::query()
            ->with(['images', 'variants'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('storefront.products.index', [
            'products' => $products,
            'search' => $search,
        ]);
    }

    public function detail(Product $product): View
    {
        $product->load(['images', 'variants', 'brand', 'category', 'scents']);

        return view('storefront.products.show', [
            'product' => $product,
        ]);
    }

    public function about(): View
    {
        return view('storefront.about.index');
    }

    public function contact(): View
    {
        return view('storefront.contact.index');
    }
}
