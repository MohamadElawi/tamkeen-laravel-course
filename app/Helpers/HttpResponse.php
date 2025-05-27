<?php


if (!function_exists('sendResponce')){
    function sendResponce($data = null, $message, $code = 200, $withPagination = false)
    {
        $responseData = [
            'success' => $code == 200 || 201,
            'message' => $message,
            'data' => $data,
        ];

        if ($withPagination) {
            $responseData['pagination'] = getPaginationData($data);
        }

        return response()->json($responseData, $code);
    }
}


if(!function_exists('sendError')){
    function sendError($message, $code = 400)
    {
        return response()->json([
            'success' => $code == 200,
            'data' => null,
            'message' => $message,
        ], $code);
    }
}

if(!function_exists('getPaginationData')){

    function getPaginationData($collection)
    {
        return [
            'current_page' => $collection->currentPage(),
            'next_page_url' => $collection->nextPageUrl(),
            'prev_page_url' => $collection->previousPageUrl(),
            'first_page_url' => $collection->url(1),
            'last_page_url' => $collection->url($collection->lastPage()),
            'per_page' => $collection->perPage(),
            'total' => $collection->total()
        ];
    }
}

