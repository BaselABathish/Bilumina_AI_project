<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Embedding;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Validator;


class FormController extends Controller
{
    public function handleForm(Request $request)
    {

        //var_dump($request);
        //print_r($request->all());
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

            case 'EMBED':
                $jsonData = $data['json_content'] ?? null;

                // Assign directly (if $jsonData is already structured correctly)
                $payload['content'] = [
                    'json_content' => $jsonData
                ];

                break;
        }


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('http://localhost:8000/ai_api/interact', $payload);



        switch ($data['type']) {
            case 'LIST_ASSISTANTS':
                $data = $response->json();
                $assistants = $data['detail']['response'] ?? [];
                return view('list_asst', compact('assistants'));

            case 'LIST_VECTOR_STORES':
                $data = $response->json();
                $vs = $data['detail']['response']['data'] ?? [];
                return view('list_vs', compact('vs'));

            case 'DELETE_ASSISTANT':
                return redirect('/');
            case 'DELETE_VECTOR_STORE':
                return redirect('/');

            case 'ADD_ASSISTANT':
                return redirect('/');
            case 'ADD_VECTOR_STORE':
                return redirect('/');

            case 'EMBED':
                $data = $response->json();

                //var_dump($data);
                $embedding =  $data['detail']['response'][0]['embedding'];
                var_dump($request->all());

                $validated = Validator::make($request->all(), [
                    'item_name' => 'required|string', // Ensure it exists and is a string
                ])->validate();

                Embedding::create([
                    'item_name' => $validated['item_name'], // Guaranteed to exist
                    'vector' => $embedding,
                ]);
        }
    }
    //
}
