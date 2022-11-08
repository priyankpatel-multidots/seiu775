<?php if (!empty($social_profiles)) : ?>
  <div class="block-social-profiles">
    <?php if (!empty($social_block_title)) :?>
      <p class="block__title"><?php echo $social_block_title; ?></p>
    <?php endif; ?>
    <ul>
      <?php
      foreach ($social_profiles as $item):
        $user = get_field($item . '_link');
        $icon_file_name = $item;
        $link = get_field($item . '_link');

        if($item == 'email') {
          $icon_file_name = 'email-colored';
          $link = 'mailto:' . $link;
        }

        $file_url = "inc/svg-icons/icon-" . $icon_file_name . ".php";
        if ($user) : ?>
          <li>
            <a href="<?php echo $link; ?>"
            target="_blank" rel="noopener noreferrer"
            class="social_link <?php echo $item ?>">
              <?php include( locate_template( $file_url )); ?> 
              <span class="text visually-hidden"><?php echo $item ?></span>
            </a>
          </li>
        <?php
        endif;
      endforeach;
      ?>
    </ul>
  </div>
<?php endif; ?>