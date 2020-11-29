<?php

namespace Leugin\ApiResponse\Helpers;


use Illuminate\Http\Response;

abstract class ApiResponse
{
    public static function created($data = [])
    {
        return response()->json(['status' => Response::HTTP_CREATED, 'data' => $data], Response::HTTP_CREATED);
    }

    public static function success($data = [])
    {
        return response()->json(['status' => Response::HTTP_OK, 'data' => $data], Response::HTTP_OK);
    }

    public static function array($data = [])
    {
        return response()->json(['data' => $data, 'status'=>Response::HTTP_OK], Response::HTTP_OK);
    }

    public static function raw($data)
    {
        return $data;
    }
    /**
     * Create new anonymous resource collection.
     *
     * @param  mixed  $resource
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        return $resource->additional(['status'=>Response::HTTP_OK]);
    }

    public static function message(string  $message, $data = [], $status = Response::HTTP_OK, $dev = null)
    {

        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];

        if ($dev) {
            $response['dev'] = $dev;
        }

        return response()->json($response, $status);
    }
    public static function messageFail($message = null, $data = [], $status = 422, $dev = null)
    {
        $message = !is_null($message) ? $message : __('Bad request');

        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];

        if ($dev && config('app.debug')) {
            $response['dev'] = $dev;
        }

        return response()->json($response, $status);
    }

    public static function messageOk($message, $data = [])
    {

        $response = [
            'status' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public static function unAuthorized($message = null, $data = [])
    {
        $message = !is_null($message) ? $message : __('messages.commons.un-authorized');

        $response = [
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }

    public static function notFound($message = null, $data = [])
    {
        $message = !is_null($message) ? $message : __('Not found');

        $response = [
            'status' => Response::HTTP_NOT_FOUND,
            'message' => $message
        ];
        if (isset($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, Response::HTTP_NOT_FOUND);
    }

    public static function exception(\Exception $e, $message = null, $data = [])
    {
        $message = !is_null($message) ? $message : __('Bad request');
        $exception = [
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => $message
        ];

        if (config('app.debug')) {
            $dev  = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'exception' => $e->getMessage(),
            ];
            error_log($message, $dev);
            $exception['dev'] = $dev;
         }
        $data = array_merge($data, $exception);

        return response()->json($data, Response::HTTP_BAD_REQUEST);
    }

    public static function errorValidation($message, $dev = [])
    {
        return response()->json(['status' => Response::HTTP_UNPROCESSABLE_ENTITY, 'dev' => $dev, 'message' => $message], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public static function badRequest( array  $dev , $message = null)
    {
        $message = !is_null($message) ? $message : __('Bad request');
        return response()->json(['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'dev' => $dev, 'message' => $message], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function partialContent($data = [])
    {
        return response()->json(['status' => Response::HTTP_PARTIAL_CONTENT, 'data' => $data], Response::HTTP_PARTIAL_CONTENT);
    }
}
