<?php
class DCHtml extends CHtml
{
	public static function button($label='button',$htmlOptions=array())
	{
		if(!isset($htmlOptions['name']))
		{
			if(!array_key_exists('name',$htmlOptions))
				$htmlOptions['name']=self::ID_PREFIX.self::$count++;
		}
		if(!isset($htmlOptions['type']))
			$htmlOptions['type']='button';
		if(!isset($htmlOptions['value']))
			$htmlOptions['value']=$label;
		self::clientChange('click',$htmlOptions);
		
		return self::tag('button',$htmlOptions, '<span><span>'.$label.'</span></span>');
	}
	
	public static function link($text,$url='#',$htmlOptions=array())
	{
		if($url!=='')
			$htmlOptions['href']=self::normalizeUrl($url);
		self::clientChange('click',$htmlOptions);
		if (!isset($htmlOptions['title'])) {
			$htmlOptions['title'] = $text;
		}
		return self::tag('a',$htmlOptions,$text);
	}
}
?>