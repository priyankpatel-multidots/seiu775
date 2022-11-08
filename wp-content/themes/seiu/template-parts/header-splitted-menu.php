<?php
  $primary_menu_items = wp_get_nav_menu_items('header-menu');
?>

<ul id="primary-menu" class="menu">
  <?php
    for ($i=0; $i < sizeof($primary_menu_items); $i++) { 
      $menu_item = $primary_menu_items[$i];
      if ($menu_item->menu_item_parent == 0) {
        echo "<li id='menu-item-" . $menu_item->ID . "' class='menu-item menu-item-type-post_type menu-item-object-page menu-item-" . $menu_item->ID . "'>";
        echo "<a href='" . $menu_item->url . "'>" . $menu_item->title . "</a>";
        echo "</li>";
      }
    }
  ?>
</ul>

<div id="primary-menu-content" class="menu menu--primary-content">
  <div class="container container--md">
  <?php
    for ($i=0; $i < sizeof($primary_menu_items); $i++) { 
      $menu_item = $primary_menu_items[$i];
      $parent_id = $menu_item->menu_item_parent;

      if ($parent_id != 0) {
        $prev_menu_item = $primary_menu_items[$i - 1];
        $prev_parent_id = $prev_menu_item->menu_item_parent;

        if ($parent_id != $prev_parent_id) {
          echo '</ul>';
          echo '<ul class="sub-menu">';
        }

        echo "<li id='menu-item-" . $menu_item->ID . "' class='menu-item menu-item-type-post_type menu-item-object-page menu-item-" . $menu_item->ID . "'>";
        echo "<a href='" . $menu_item->url . "'>" . $menu_item->title . "</a>";
        echo "</li>";
      }
    }
  ?>
  </div>
</div>