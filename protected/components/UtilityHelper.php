<?php

/*
 *$Id: UtilityHelper.php 2478 2011-09-06 00:59:52Z shearf $
 * */
class UtilityHelper 
{
    /*
     *@author shearf
     * */
	public static function renameUploadFile($filename)
	{
		$pathinfo = pathinfo($filename);
		
		return time().floor((microtime()*1000)).rand(0, 1000).'.'.$pathinfo['extension'];
	}
	/**
	 * 得到客户端IP
	 * @author tomatosun
	 * */
	public static function getClientIp()
	{
		$clientIp = '';
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$clientIp = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$clientIp = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$clientIp = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$clientIp = $_SERVER['REMOTE_ADDR'];
		}
		if(!preg_match("/[\d\.]{7,15}/", $clientIp)) $clientIp = 'unknown';
		return $clientIp;
	}
	/**
	 * 创建像这样的查询: "IN('a','b')";
	 * @author   cfang
	 * @access   public
	 * @param    mix      $item_list      列表数组或字符串
	 * @param    string   $field_name     字段名称
	 *
	 * @return   void
	 */
	public static function db_create_in($item_list, $field_name = '')
	{
	    if (empty($item_list))
	    {
	        return $field_name . " IN ('') ";
	    }
	    else
	    {
	        if (!is_array($item_list))
	        {
	            $item_list = explode(',', $item_list);
	        }
	        $item_list = array_unique($item_list);
	        $item_list_tmp = '';
	        foreach ($item_list AS $item)
	        {
	            if ($item !== '')
	            {
	                $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
	            }
	        }
	        if (empty($item_list_tmp))
	        {
	            return $field_name . " IN ('') ";
	        }
	        else
	        {
	            return $field_name . ' IN (' . $item_list_tmp . ') ';
	        }
	    }
	}
	/**
	 * 截取UTF-8编码下字符串的函数
	 * @author   cfang 
	 * @param   string      $str        被截取的字符串
	 * @param   int         $length     截取的长度
	 * @param   bool        $append     是否附加省略号
	 * @param   string      $charset     字符串编码
	 *
	 * @return  string
	 */
	public static function sub_str($string, $length = 0, $append = true,$charset="utf-8")
	{
	
	    if(strlen($string) <= $length) {
	        return $string;
	    }
	
	    $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	
	    $strcut = '';
	
	    if(strtolower($charset) == 'utf-8') {
	        $n = $tn = $noc = 0;
	        while($n < strlen($string)) {
	
	            $t = ord($string[$n]);
	            if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
	                $tn = 1; $n++; $noc++;
	            } elseif(194 <= $t && $t <= 223) {
	                $tn = 2; $n += 2; $noc += 2;
	            } elseif(224 <= $t && $t < 239) {
	                $tn = 3; $n += 3; $noc += 2;
	            } elseif(240 <= $t && $t <= 247) {
	                $tn = 4; $n += 4; $noc += 2;
	            } elseif(248 <= $t && $t <= 251) {
	                $tn = 5; $n += 5; $noc += 2;
	            } elseif($t == 252 || $t == 253) {
	                $tn = 6; $n += 6; $noc += 2;
	            } else {
	                $n++;
	            }
	
	            if($noc >= $length) {
	                break;
	            }
	
	        }
	        if($noc > $length) {
	            $n -= $tn;
	        }
	
	        $strcut = substr($string, 0, $n);
	
	    } else {
	        for($i = 0; $i < $length; $i++) {
	            $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
	        }
	    }
	
	    $strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	
	    if ($append && $string != $strcut)
	    {
	        $strcut .= '...';
	    }
	
	    return $strcut;
	
	}
	
	public static function addHttpForUrl($url)
	{
		if (strpos($url, 'http://') === 0) {
			return $url;
		}
		else {
			return 'http://'.$url;
		}
	}
	/**
	 * 
	 * 截取两个字符中间的字符串
	 * @param $char $startChr
	 * @param $char $endChr
	 * @param $integer $offset
	 * @param $string $str
	 */
	public static function subString($str, $startChr, $endChr, $offset = 0)
	{
		$start = strpos($str, $startChr, $offset) + 1;
		/*
		if ($startChr === $endChr) {
			return substr($str,  $start, strpos($str, $endChr, $start) - $start);
		}
		else
		*/ 
			return substr($str,  $start, strpos($str, $endChr) - $start);
	}
}



?>
