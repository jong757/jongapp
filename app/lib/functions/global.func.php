<?php
/**
 *  global.func.php 公共函数库
 *
 * @copyright			(C) 2024-2025 Jong 
 * @license				qq:3865176
 * @lastmodify			2024-11-14 
 */

/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_addslashes($string){
	if(!is_array($string)) return addslashes($string);
	foreach($string as $key => $val) $string[$key] = new_addslashes($val);
	return $string;
}

/**
 * 返回经stripslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes($string) {
	if(!is_array($string)) return stripslashes($string);
	foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
	return $string;
}

/**
 * xss过滤函数
 *
 * @param $string
 * @return string
 */
function remove_xss($string, $options = array(), $spec = '') {
    if (!is_array($string)) {
        if (!function_exists('htmLawed')) {
            base::load_sys_func('htmLawed');
        }
        return htmLawed($string, array_merge(array('safe' => 1, 'balanced' => 0), $options), $spec);
    }
    foreach ($string as $k => $v) {
        $string[$k] = remove_xss($v, $options, $spec);
    }
    return $string;
}


/**
 * GetCustom URL Route
 * 获取自定义 URL 路由
 *
 * @param array|string $keys 数组时，表示 m=0, c=1, a=2；字符串时，表示获取键值
 * @param string $type URL 参数转换类型，默认为 'get'
 * @return array|string 返回路由数组或 GET 参数字符串
 */
function Gr($keys = [], $type = 'get') {
    $param = base::load_sys_class('Param');
    $param = new Param();
    if (is_array($keys)) {
        $routes = [];
        $keysCount = count($keys);
		
        // 处理 keys 数组中的每个元素
        for ($i = 0; $i < $keysCount; $i++) {
            if (!empty($keys[$i])) {
                $routes[$param->getRoute($i)] = $keys[$i];
            }
        }

        // 如果 keys 数量为 1，不补全其他默认值
        if ($keysCount == 1) {
            return $type == 'get' ? DEFAULTS . '?' . http_build_query([$param->getRoute(0) => $keys[0]]) : [$param->getRoute(0) => $keys[0]];
        }
        // 如果 keys 数量为 2，补全第二个默认值并显示第三个键值
        if ($keysCount == 2) {
            $routes[$param->getRoute(1)] = $param->route_config[$param->getRoute(1)];
            $routes[$param->getRoute(2)] = $keys[1];
        }
		// print_r($routes);
        return $type == 'get' ? DEFAULTS . '?' . http_build_query($routes) : $routes;
    } else {
        return $param->getRoute($keys);
    }
}



/**
 * 提示信息页面跳转，跳转地址如果传入数组，页面会提示多个地址供用户选择，默认跳转地址为数组的第一个值，时间为5秒。
 * message('登录成功', array('默认跳转地址'=>'http://www.phpcms.cn'));
 * @param string $msg 提示信息
 * @param int $code 成功1 失败0
 * @param string/array  $url_forward 跳转地址
 * @param int $ms 跳转等待时间
 * @param int $datas 数据
 */
function message($msg, $code = false, $datas = '', $url_forward = '', $ms = 1250) {
    if($url_forward === HTTP_REFERER){
        $url_forward = html_entity_decode(remove_xss(safe_replace($url_forward)));
    }
	$code = $code ? 1 : 0;
	if(defined('IN_ADMIN')) {
		$response = [
			'code'=>$code,
			'msg'=>$msg,
			'ms'=> $ms,
		];
		if (!empty($url_forward)) {
			$response['url_forward'] = $url_forward;
		}
		if (!empty($datas)) {
			$response['data'] = $datas;
		}
		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode($response,325);
	} else {
		include(template('content', 'message'));
	}
	exit;
}

