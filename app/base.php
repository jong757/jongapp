<?php
 /**
 *  base.php 全局加载控制器 
 *
 * @copyright			(C) 2024-2025 Jong 
 * @license				qq:3865176
 * @lastmodify			2024-11-14 
 */

//当前框架路径
define('PATH', dirname(__FILE__).DS);

//加载公共方法库
base::load_func('global');
//加载常量库
base::load_def('constant');



class base {
	/**
	* 创建应用程序实例
	*/
	public static function app() {
		return self::load_sys_class('application');
	}
	/**
	* 加载系统类
	*/
	public static function load_sys_class($classname, $path = '', $initialize = 1) {
		return self::load_class($classname, $path, $initialize);
	}
	/**
	* 加载应用类
	*/
	public static function load_app_class($classname, $m = '', $initialize = 1) {
		$m = empty($m) && defined('ROUTE_M') ? ROUTE_M : $m;
		return $m ? self::load_class($classname, self::get_module_path($m, 'classes'), $initialize) : false;
	}
	/**
	* 加载数据模型
	*/
	public static function load_model($classname) {
		return self::load_class($classname, 'model');
	}
	
	/**
	* 获取模块的路径
	*/
	public static function get_module_path($m, $subdir = '') {
		return 'modules' . DS . $m . DS . $subdir;
	}
	
	/**
	* 加载函数库
	*/
	public static function load_func($func, $path = '') {
		return self::load_file($func, $path ?: 'lib' . DS . 'functions', 'func.php');
	}
	
	/**
	* 加载常量库
	*/
	public static function load_def($func, $path = '') {
		return self::load_file($func, $path ?: 'lib' . DS,'der.php');
	}
	/**
	* 加载配置和资源
	*/
	public static function load_config($paths, $file, $key = '', $default = '', $reload = false) {
		static $configs = [];
		if (!$reload && isset($configs[$file])) {
			return empty($key) ? $configs[$file] : ($configs[$file][$key] ?? $default);
		}
		$path = $paths . $file . '.php';
		
		if (file_exists($path)) {
			$configs[$file] = include $path;
		}
		return empty($key) ? $configs[$file] : ($configs[$file][$key] ?? $default);
	}
	
	/**
	* 加载类文件
	*/
	private static function load_class($classname, $path = '', $initialize = 1) {
		static $classes = [];
		// 默认路径处理
		$path = self::normalize_path($path ?: 'lib' . DS . 'classes');
		$key = md5($path . $classname);
		// 如果已经加载过，直接返回
		if (isset($classes[$key])) {
			return $classes[$key] === false ? false : $classes[$key];
		}
		// 拼接完整路径并加载类
		$file_path = PATH . $path . DS . $classname . '.class.php';
		if (file_exists($file_path)) {
			include $file_path;
			$name = $classname;
			$classes[$key] = $initialize ? new $name : true;
			return $classes[$key];
		}
		return false;
	}

	/**
	* 加载文件
	*/
	private static function load_file($name, $path, $extension) {
		static $loaded_files = [];
		$path = self::normalize_path($path);
		$file_path = $path . DS . $name . '.' . $extension;
		$key = md5($file_path);
		if (isset($loaded_files[$key])) return true;
		if (file_exists(PATH . $file_path)) {
			include PATH . $file_path;
			$loaded_files[$key] = true;
			return true;
		}
		$loaded_files[$key] = false;
		return false;
	}

	/**
	* 标准化路径，避免重复拼接
	*/
	private static function normalize_path($path) {
		return rtrim($path, DS);
	}

}