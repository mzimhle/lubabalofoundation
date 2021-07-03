<?php
/*
 * Smarty plugin "ImageText"
 * Purpose: creates graphical headlines
 * Home: http://www.cerdmann.com/imagetext/
 * Copyright (C) 2005 Christoph Erdmann
 *
 * This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; either version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA
 * -------------------------------------------------------------
 * For changelog take a look at shared.imagetext.php
 * -------------------------------------------------------------
 */

function smarty_function_imagetext($params, &$smarty) {
	if ($params['text'] != '') {
		require_once $smarty->_get_plugin_filepath('shared','imagetext');
		return smarty_imagetext($params);
	}
}

?>