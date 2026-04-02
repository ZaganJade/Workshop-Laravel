<?php

namespace App\Http\Controllers\Chatbot;

use App\Http\Controllers\Controller;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * The AI service.
     */
    protected AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Handle the chat request and return a response.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Pesan tidak valid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $userMessage = $request->input('message');
        $aiResponse = $this->aiService->getResponse($userMessage);

        return response()->json([
            'success' => true,
            'message' => $aiResponse,
            'user_message' => $userMessage,
        ]);
    }
}
