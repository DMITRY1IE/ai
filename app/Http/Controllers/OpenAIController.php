<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;

class OpenAIController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function showForm()
    {
        return view('openai.index', [
            'history' => session('history', []), // Загружаем историю сообщений из сессии
        ]);
    }

    public function processQuestion(Request $request)
    {
        $question = $request->input('question');

        if (!$question) {
            return response()->json(['error' => 'Question is required'], 400);
        }

        // Загружаем историю из сессии или создаём новую
        $history = session('history', []);

        // Добавляем новый запрос в историю
        $history[] = ['role' => 'user', 'content' => $question];

        // Отправляем историю в OpenAI
        $response = $this->openAIService->askQuestionWithContext($history);

        if ($response) {
            // Добавляем ответ ассистента в историю
            $history[] = ['role' => 'assistant', 'content' => $response];

            // Сохраняем обновлённую историю в сессии
            session(['history' => $history]);

            return view('openai.index', [
                'history' => $history, // Передаём всю историю в шаблон
            ]);
        } else {
            return view('openai.index', [
                'history' => $history,
                'error' => 'Ошибка при запросе к API.',
            ]);
        }
    }
    // Метод для очистки истории
    public function clearHistory()
    {
        session()->forget('history'); // Удаляем историю из сессии
        return redirect()->route('chat.form'); // Перенаправляем на страницу чата
    }
}
