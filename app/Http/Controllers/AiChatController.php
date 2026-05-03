<?php

namespace App\Http\Controllers;

use App\Services\AiRecommendationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiChatController extends Controller
{
    public function chat(Request $request, AiRecommendationService $service): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array|max:20',
            'history.*.role' => 'required_with:history|string|in:user,model',
            'history.*.text' => 'required_with:history|string|max:2000',
        ]);

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        // Add the new user message to history
        $history[] = [
            'role' => 'user',
            'text' => $userMessage,
        ];

        $result = $service->chat($history);

        return response()->json($result);
    }
}
