<?php

if (!function_exists('generate_meta')) {
	/**
	 * generate response meta according to status
	 * @param  mixed $status
	 * @param  string $errorMessage
	 * @return array
	 */
	function generate_meta($status, $errorMessage = 'failure')
	{
		if (empty($status) || $status === 'failure' || (method_exists($status, 'isEmpty') && $status->isEmpty())) {
			return [
				'code' => 0,
				'message' => $errorMessage
			];
		}

		return [
			'code' => 1,
			'message' => 'success'
		];
	}
}

if(!function_exists('request')){
	/**
	 * get parameter value from request
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	function request($request, $key, $default = null){
		list($found, $routeInfo, $params) = $request->route() ? : [false, [], []];

		if(!isset($params[$key])){
			return $default;
		}

		return $params[$key];
	}
}

if (!function_exists('get')) {
	function get($key, $default = null){
		return $_GET[$key] ?? $default;
	}
}