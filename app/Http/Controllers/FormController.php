<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FormController extends Controller
{
    public function handleForm(Request $request)
    {


        $data = $request->all();

        $payload = [
            //'_token' => $data['_token'],
            'type' => $data['type'],
            'service' => $data['service'],
            'companyId' => $data['companyId'],
            'username' => $data['username'],
            'content' => []
        ];


        switch ($data['type']) {
            case 'LIST_ASSISTANTS':
            case 'LIST_VECTOR_STORES':
                $payload['content'] = "placeholder";
                break;

            case 'DELETE_ASSISTANT':
            case 'DELETE_VECTOR_STORE':
                $payload['content']['deletion_id'] = $data['deletion_id'];
                break;

            case 'ADD_ASSISTANT':

                $payload['content'] = [
                    'instructions' => $data['instructions'] ?? null,
                    'name' => $data['name'] ?? null,
                    'model' => $data['model'] ?? 'gpt-4',
                    'description' => $data['description'] ?? null,
                    'reasoning_effort' => $data['reasoning_effort'] ?? null,
                    'response_format' => $data['response_format'] ?? null,
                    'temperature' => (float) $data['temperature']?? null,
                    'tool_resources' => $data['tool_resources'] ?? null,
                    'tools' => $data['tools'] ?? null,
                    'top_p' => $data['top_p'] ?? null
                ];
                break;

            case 'ADD_VECTOR_STORE':
                $payload['content'] = [
                    'name' => $data['name'] ?? null,
                    'chunking_strategy' => $data['chunking_strategy'] ?? null,
                    'expires_after' => $data['expires_after'] ?? null,
                    'file_ids' => $data['file_ids'] ?? null,
                    'metadata' => $data['metadata'] ?? null
                ];
                break;

        }


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('http://localhost:8000/ai_api/interact', $payload);

        return response()->json([
            'sent_to_python_api' => $payload,
            'response_from_python' => $response->json()
        ]);
    }
    //
}
