<?php

class Utils {
	public static function fuzzyTime($from, $to = NULL) {
		if (!is_numeric($from)) {
			// handle dates graciously
			$from = strtotime($from);
		}
		if ($to === NULL) {
			$to = time();
		} else if (!is_numeric($to)) {
			$to = strtotime($to);
		}

		$elapsed = $to - $from;
		if ($elapsed < 30) {
			return "Just now";
		}
		if ($elapsed < 60) {
			return "About a minute ago";
		}
		
		// catch all
		$days = floor($elapsed / 86400);
		$str = $days." day";
		if ($days != 1) {
			$str .= "s";
		}
		$str .= " ago";
		return $str;
	}
	
	public static function fromCamelCase($str) {
		$str[0] = strtolower($str[0]);
		$func = create_function('$c', 'return "_" . strtolower($c[1]);');
		return preg_replace_callback('/([A-Z])/', $func, $str);
	}

    /* borrowed with thanks from http://wiki.jumba.com.au/wiki/PHP_Generate_random_password */
    public static function generatePassword($length) {
        $chars = "234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $i = 0;
        $password = "";
        while ($i <= $length) {
            $password .= $chars{mt_rand(0,strlen($chars))};
            $i++;
        }
        return $password;
    }

}
