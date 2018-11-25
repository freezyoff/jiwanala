<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception){
		if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->view(
				$this->getExceptionViewPath($request,'http_error_code'),
				['code'=>'404', 'message'=>trans('http_error.404')], 
				404);
		}
		elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException){
			return response()->view(
				$this->getExceptionViewPath($request,'http_error_code'), 
				['code'=>'403', 'message'=>trans('http_error.403')], 
				403);
		}
        return parent::render($request, $exception);
    }
	
	protected function getExceptionViewPath($request, $viewName){
		//my.jiwa-nala domain
		if ( strpos($request->url(), 'my.jiwa-nala') !== false ){
			return "my.exception.".$viewName;
		}
		
		//other domain
		return "exception.".$viewName;
	}
}
