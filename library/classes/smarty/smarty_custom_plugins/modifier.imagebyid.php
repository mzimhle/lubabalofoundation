<?php
/*
 * Smarty {Image By Id} modifier plugin
 *
 * Examples:
 * {source|imageById}
 *
 * @author     Johan Steyn <johan@clickthinking.com>
 * @version    1.0
 * @date 19 October 2007
 * @ id INT
 * @return boolean
 */
function smarty_modifier_imagebyid($id)
{
		global $conn, $site_config;
		$blockSql = "select block_filename from block where pk_block_id=".$id; 
		$block = $conn->CacheGetOne($site_config['extra_long_cache'],$blockSql);//search for filename and returns it
		return $block;
}
?>