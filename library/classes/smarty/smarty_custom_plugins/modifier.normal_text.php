<?php
/*
 * Smarty {File exists} modifier plugin
 *
 * Examples:
 * {source|file_exists}
 *
 * @author     Johan Steyn <johan@clickthinking.com>
 * @version    1.0
 * @date 19 October 2007
 * @ src String (filename or url)
 * @return boolean
 */
function smarty_modifier_normal_text($string)
{
	return preg_replace('/\s{2,}/', ' ', $string);
}
?>