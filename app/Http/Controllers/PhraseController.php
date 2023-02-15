<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PhraseController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $type = $request->query('type', 'awesome');
        $sweetness = $request->query('sweetness', '1');

        // Grab the phrases from the config file
        $phrases = config('phrases');

        // Split type into array
        $type = explode(",", $type);

        // Get random value from array
        $type = Arr::random($type);

        // Split sweetness into array
        $sweetness = explode(",", $sweetness);

        // Get random value from array
        $sweetness = Arr::random($sweetness);

        // Make sure we don't use a sweetness level that doesn't exist
        if($sweetness > count($phrases[$type])) {
            $sweetness = '1';
        }

        $phrase = Arr::random($phrases[$type][$sweetness]);

        $data = [
            "type" => $type,
            "sweetness" => $sweetness,
            "phrase" => $phrase["phrase"],
            "credit" => $phrase["credit"]
        ];

        return response()->json($data);
    }
}
