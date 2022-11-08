<?php

// note:
// if you want to change the order of the post types in the admin menu, add "menu_position" => #, to the post type args

$post_type_includes = [
	'inc/post-types/member-offerings.php',
];

foreach ($post_type_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'seiu'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}

