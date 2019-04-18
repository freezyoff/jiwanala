<?php

namespace App\Http\Middleware;

use Closure;

class MinifyReponseOutputString
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
		
        if ($this->isResponseObject($response) && $this->isHtmlResponse($response) && !$this->isResponseStackTrace($response)) {
			$comments = 
				'/'.
					'\<!--(.|\n)*?--\>|'.		//html comment
					'(?<=\s)\/\/.*\s+|'.		//js comment line //
					'\/\*((.|\s)*?)\*\/|'.		//js comment /* */
				'/';
				
			$replace = [
				$comments					=>'',
				'/(?<=\>)\s+|\s+(?=\<)|/'	=>'',	//whitespace before & after tag
				'/\s{2,}/'					=>' ',	//white space with ended
			];
            $response->setContent(preg_replace(array_keys($replace), array_values($replace), $response->getContent()));
        }

        return $response;
    }

    protected function isResponseObject($response)
    {
        return is_object($response) && $response instanceof \Illuminate\Http\Response;
    }

    protected function isHtmlResponse(\Illuminate\Http\Response $response)
    {
		return preg_match('/text\/html/',$response->headers->get('Content-Type'));
    }
	
	protected function isResponseStackTrace(\Illuminate\Http\Response $response){
		return preg_match('/Whoops container/',$response->getContent());
	}
}
