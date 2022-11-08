<?php
/**
 * Template for Role based settings
 *
 * @package inactive-logout
 */

?>
<div class="ina-settings-admin-wrap">
	<?php $result_roles = \Codemanas\InactiveLogout\Helpers::getAllRoles(); ?>
  <div id="message" class="updated notice is-dismissible" style="display: none;"></div>

  <form method="post" class="ina-form" action="?page=inactive-logout&tab=ina-advanced">
	  <?php wp_nonce_field( '_nonce_action_save_timeout_adv_settings', '_save_timeout_adv_settings' ); ?>
    <table class="ina-form-tbl form-table">
      <tbody>
      <tr>
        <th scope="row"><label
            for="ina_enable_different_role_timeout"><?php esc_html_e( 'Multi-Role Timeout', 'inactive-logout' ); ?></label>
        </th>
        <td>
          <input name="ina_enable_different_role_timeout" type="checkbox"
                 id="ina_enable_different_role_timeout" <?php echo ! empty( $ina_multiuser_timeout_enabled ) ? 'checked' : false; ?>
                 value="1">
          <p class="description"><?php esc_html_e( 'This will enable multi-user role timeout functionality.', 'inactive-logout' ); ?></p>
        </td>
      </tr>
      <tr class="ina-multi-role-table" <?php echo ! empty( $ina_multiuser_timeout_enabled ) && (int) $ina_multiuser_timeout_enabled === 1 ? 'style="display:table-row;"' : 'style="display:none;"'; ?>>
        <th scope="row"><label
            for="idle_timeout"><?php esc_html_e( 'Enable Multi-User Feature', 'inactive-logout' ); ?></label>
        </th>
        <td>
          <select class="ina-hacking-multi-select" id="ina_definetime_specific_userroles" multiple="multiple"
                  name="ina_multiuser_roles[]">
			  <?php
			  foreach ( $result_roles as $k => $role ) {
				  $selected = \Codemanas\InactiveLogout\Helpers::CheckRoleForMultiUser( $k );
				  ?>
                <option value="<?php echo esc_attr( $k ); ?>" <?php echo ! empty( $selected ) ? 'selected' : false; ?>><?php echo esc_html( $role ); ?></option>
				  <?php
			  }
			  ?>
          </select>
          <p class="description">
            <i><?php esc_html_e( 'This will allow you to define different timeout constraint according to different selected user roles.', 'inactive-logout' ); ?></i>
          </p>
        </td>
      </tr>
      </tbody>
    </table>
	  <?php
	  if ( ! empty( $ina_multiuser_settings ) ) {
		  $posts = \Codemanas\InactiveLogout\Helpers::getAllPostsPages();
		  ?>
        <table class="ina-form-tbl ina-multi-role-table wp-list-table widefat fixed striped pages">
          <thead>
          <th class="manage-column" width="10%"><?php esc_html_e( 'User Role', 'inactive-logout' ); ?></th>
          <th class="manage-column" width="15%">
			  <?php esc_html_e( 'Timeout (In Minutes)', 'inactive-logout' ); ?>
            <div class="tooltip"><span class="dashicons dashicons-info"></span>
              <span class="tooltiptext"><?php _e( 'Set different timeout duration for each user roles.', 'inactive-logout' ); ?></span>
            </div>
          </th>
          <th class="manage-column" width="35%">
			  <?php esc_html_e( 'Redirect Page', 'inactive-logout' ); ?>
            <div class="tooltip"><span class="dashicons dashicons-info"></span>
              <span class="tooltiptext"><?php _e( 'Set different redirect page url for each user roles. This is affected when a user is logged out.', 'inactive-logout' ); ?></span>
            </div>
          </th>
          <th class="manage-column">
			  <?php esc_html_e( 'Disable Inactive Logout', 'inactive-logout' ); ?>
            <div class="tooltip"><span class="dashicons dashicons-info"></span>
              <span class="tooltiptext"><?php _e( 'Checking below will disable inactive logout functionality for selected user role.', 'inactive-logout' ); ?></span>
            </div>
          </th>
          <th class="manage-column">
			  <?php esc_html_e( 'Prevent Multiple Logins', 'inactive-logout' ); ?>
            <div class="tooltip"><span class="dashicons dashicons-info"></span>
              <span class="tooltiptext tooltiptext-left"><?php _e( 'Checking below will prevent the selected user role from logging in at multiple locations.', 'inactive-logout' ); ?></span>
            </div>
          </th>
		  <?php do_action( 'ina__addon_role_based_elements_table_head' ); ?>
          </thead>
          <tbody>
		  <?php
		  foreach ( $ina_multiuser_settings as $k => $ina_multiuser_setting ) {
			  $role = $ina_multiuser_setting['role'];
			  ?>
            <tr>
              <td><?php echo esc_html( $result_roles[ $role ] ); ?></td>
              <td>
                <input type="number" min="1"
                       value="<?php echo ( ! empty( $ina_multiuser_setting['timeout'] ) ) ? esc_attr( $ina_multiuser_setting['timeout'] ) : 15; ?>"
                       name="ina_individual_user_timeout[]">
              </td>
              <td>
                <select name="ina_redirect_page_individual_user[]" class="regular-text ina-hacking-select">
                  <option value="0"><?php esc_html_e( 'Set Global Redirect Page', 'inactive-logout' ); ?></option>
					<?php
					if ( ! empty( $posts ) ) {
						foreach ( $posts as $k => $post_types ) {
							?>
                          <optgroup label="<?php echo ucfirst( $k ); ?>">
							  <?php foreach ( $post_types as $post_type ) { ?>
                                <option <?php echo ( intval( $ina_multiuser_setting['redirect_page'] ) === $post_type['ID'] ) ? esc_attr( 'selected' ) : ''; ?>
                                  value="<?php echo esc_attr( $post_type['ID'] ); ?>">
									<?php echo esc_html( $post_type['title'] ); ?>
                                </option>
							  <?php } ?>
                          </optgroup>
							<?php
						}
					} else {
						?>
                      <option value=""><?php esc_html_e( 'No Posts Found.', 'inactive-logout' ); ?></option>
						<?php
					}
					?>
                </select>
              </td>
              <td>
                <input type="checkbox"
                       name="ina_disable_inactive_logout[<?php echo esc_attr( $role ); ?>]" <?php echo ( ! empty( $ina_multiuser_setting['disabled_feature'] ) ) ? esc_attr( 'checked' ) : false; ?>
                       value="1">
              </td>
              <td>
                <input type="checkbox"
                       name="ina_disable_inactive_concurrent_login[<?php echo esc_attr( $role ); ?>]" <?php echo ( ! empty( $ina_multiuser_setting['disabled_concurrent_login'] ) ) ? esc_attr( 'checked' ) : false; ?>
                       value="1">
              </td>

				<?php do_action( 'ina__addon_role_based_elements_table_body', $role, $ina_multiuser_setting ); ?>
            </tr>
		  <?php } ?>
          </tbody>
        </table>
	  <?php } ?>

	  <?php do_action( 'ina__after_advanced_form_elements' ); ?>

    <p class="ina_adv_submit">
      <input type="submit" name="adv_submit" id="submit" class="button button-primary"
             value="<?php esc_html_e( 'Save Changes', 'inactive-logout' ); ?>">
      <a id="ina-reset-adv-data" class="button button-primary button-reset-ina"
         data-msg="<?php esc_html_e( 'Are you sure you want to erase all advanced settings? This cannot be undone.', 'inactive-logout' ); ?>"><?php esc_html_e( 'Reset Role Based Settings', 'inactive-logout' ); ?></a>
    </p>
  </form>
</div>
<script>
  jQuery(function ($) {
    $('.ina-hacking-multi-select').select2({
      width: '100%',
    })
  })
</script>