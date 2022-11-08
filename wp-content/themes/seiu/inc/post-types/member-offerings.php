<?php
function cptui_register_my_cpts_member_offerings() {

    /**
     * Post Type: Member offerings.
     */

    $labels = array(
        "name" => __( "Member offerings", "seiu" ),
        "singular_name" => __( "Member offering", "seiu" ),
    );

    $args = array(
        "label" => __( "Member offerings", "seiu" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "membership-plus", "with_front" => true , "pages" => false),
        // "rewrite" => array( "slug" => "%category%", "with_front" => true , "pages" => false),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail", "excerpt" ),
        "taxonomies" => array("category", "post_tag"),
        "menu_icon" => "dashicons-welcome-write-blog",
    );

    register_post_type( "member_offering", $args );
}


function member_offering_category_taxonomy() {

    $labels = array(
        'name'                       => 'Member Offering Category',
        'singular_name'              => 'Member Offering Category',
        'menu_name'                  => 'Member Offering Category',
        'all_items'                  => 'All Member Offering Category',
        'parent_item'                => 'Parent Member Offering Category',
        'parent_item_colon'          => 'Parent Member Offering Category:',
        'new_item_name'              => 'New Member Offering Category Name',
        'add_new_item'               => 'Add New Member Offering Category',
        'edit_item'                  => 'Edit Member Offering Category',
        'update_item'                => 'Update Member Offering Category',
        'view_item'                  => 'View Member Offering Category',
        'separate_items_with_commas' => 'Separate Member Offering Category with commas',
        'add_or_remove_items'        => 'Add or remove Member Offering Category',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Member Offering Category',
        'search_items'               => 'Search Member Offering Category',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No Member Offering Category',
        'items_list'                 => 'Member Offering Category list',
        'items_list_navigation'      => 'Member Offering Category list navigation',
        'set_featured_image'         => 'Set Featured Image (Max Width: 400px, Max Height: 400px)',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        "show_in_rest"                   => true,
    "rest_base"                      => "",
    'rewrite' => array('slug' => 'member_offering_category')
    );
    register_taxonomy( 'member_offering_category', array( 'member_offering' ), $args );

}
// add_action( 'init', 'member_offering_category_taxonomy', 0 );

add_action( 'init', 'cptui_register_my_cpts_member_offerings' );
