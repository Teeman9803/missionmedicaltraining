<?php
/***
 * Security
 */

if (!defined('FEP')) {
    exit;
}
?>
		<div class="fep">
			<form id="your-profile" action="#fep-message" method="post"<?php do_action('user_edit_form_tag'); ?>>
			<?php wp_nonce_field('update-user_'.$user_id) ?>
			<?php if ($wp_http_referer) : ?>
				<input type="hidden" name="wp_http_referer" value="<?php echo esc_url($wp_http_referer); ?>" />
			<?php endif; ?>
			<p>
			<input type="hidden" name="from" value="profile" />
			<input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" />
			</p>

			<div class="wpcf7 wpcf7-form">
	
<?php
            do_action('personal_options', $profileuser);
            ?>
			</div>
			<?php
            do_action('profile_personal_options', $profileuser);
            ?>

			<h3><?php _e('Name', 'fep') ?></h3>

			<div class="wpcf7 wpcf7-form">
            <p>
            <?php do_shortcode('[avatar_upload]'); ?>
            </p>
            <p>
                <span class="wpcf7-form-control-wrap"><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr($profileuser->user_login); ?>" disabled="disabled" placeholder="Username" class="regular-text" /><br /><em><span class="description"><?php _e('Usernames cannot be changed.', 'fep'); ?></span></em></span>
            </p>
			<p>
				<span class="wpcf7-form-control-wrap"><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($profileuser->first_name) ?>" placeholder="First Name" class="regular-text" /></span>
			</p>

			<p>
				<span class="wpcf7-form-control-wrap"><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($profileuser->last_name) ?>" placeholder="Last Name" class="regular-text" /></span>
			</p>

			<p>
				<span class="wpcf7-form-control-wrap"><input type="text" name="nickname" id="nickname" value="<?php echo esc_attr($profileuser->nickname) ?>" placeholder="Nickname" class="regular-text" /></span>
			</p>

			<p>
				<label style="font-weight:normal" for="display_name"><h3><?php _e('Display to Public as', 'fep') ?></h3></label>
				<span class="wpcf7-form-control-wrap">
					<select name="display_name" id="display_name">
					<?php
                        $public_display = [];
                        $public_display['display_username'] = $profileuser->user_login;
                        $public_display['display_nickname'] = $profileuser->nickname;
                        if (!empty($profileuser->first_name)) {
                            $public_display['display_firstname'] = $profileuser->first_name;
                        }
                        if (!empty($profileuser->last_name)) {
                            $public_display['display_lastname'] = $profileuser->last_name;
                        }
                        if (!empty($profileuser->first_name) && !empty($profileuser->last_name)) {
                            $public_display['display_firstlast'] = $profileuser->first_name.' '.$profileuser->last_name;
                            $public_display['display_lastfirst'] = $profileuser->last_name.' '.$profileuser->first_name;
                        }
                        if (!in_array($profileuser->display_name, $public_display)) { // Only add this if it isn't duplicated elsewhere
                            $public_display = ['display_displayname' => $profileuser->display_name] + $public_display;
                        }
                        $public_display = array_map('trim', $public_display);
                        $public_display = array_unique($public_display);
                        foreach ($public_display as $id => $item) {
                            ?>
						<option id="<?php echo $id;
                            ?>" value="<?php echo esc_attr($item);
                            ?>"<?php selected($profileuser->display_name, $item);
                            ?>><?php echo $item;
                            ?></option>
					<?php

                        }
                    ?>
					</select>
				</span>
			</p>
			</div>

			<h3><?php _e('Contact Info', 'fep') ?></h3>

			<div class="wpcf7 wpcf7-form">
			<p>
				<span class="wpcf7-form-control-wrap"><input type="text" name="email" id="email" value="<?php echo esc_attr($profileuser->user_email) ?>" placeholder="Email" class="regular-text" />
				<?php
                $new_email = get_option($current_user->ID.'_new_email');
                if ($new_email && $new_email != $current_user->user_email) : ?>
				<div class="updated inline">
				<p><?php printf(__('There is a pending change of your e-mail to <code>%1$s</code>. <a href="%2$s">Cancel</a>', 'fep'), $new_email['newemail'], esc_url(get_permalink().'?dismiss='.$current_user->ID.'_new_email')); ?></p>
				</div>
				<?php endif; ?>
				</span>
			</p>

			<!-- <p>
				<span class="wpcf7-form-control-wrap"><input type="text" name="url" id="url" value="<?php echo esc_attr($profileuser->user_url) ?>" placeholder="Website" class="regular-text code" /></span>
			</p> -->

			<?php
                $contact_methods = [];

                $contact_methods = apply_filters('fep_contact_methods', $contact_methods);

                if (!(is_array($contact_methods))) {
                    $contact_methods = [];
                }
                foreach (_wp_get_user_contactmethods() as $name => $desc) {
                    if (in_array($name, $contact_methods)) {
                        continue;
                    }
                    ?>
			<p>
				<h3><label for="<?php echo $name;
                    ?>"><?php echo apply_filters('user_'.$name.'_label', $desc);
                    ?></label></th>
				<span class="wpcf7-form-control-wrap"><input type="text" name="<?php echo $name;
                    ?>" id="<?php echo $name;
                    ?>" value="<?php echo esc_attr($profileuser->$name) ?>" class="regular-text" /></span>
			</p>
			<?php

                }
            ?>
			</div>
			<?php
            if ($show_biographical):
            ?>
			<h3><?php _e('About Yourself', 'fep'); ?></h3>
			<?php
            endif;
            ?>

			<div class="wpcf7 wpcf7-form">
			<?php
            if ($show_biographical):
            ?>
			<p>
				<span class="wpcf7-form-control-wrap"><textarea name="description" id="description" rows="5" cols="30" placeholder="Description"><?php echo esc_html($profileuser->description); ?></textarea><br />
				<span class="wpcf7-form-control-wrap" class="description"><?php _e('Share a little biographical information to fill out your profile. This may be shown publicly.', 'fep'); ?></span></span>
			</p>
			<?php
            endif;
            ?>
			
			<?php
            $show_password_fields = apply_filters('show_password_fields', true, $profileuser);
            if ($show_password_fields) :
            ?>
			<p id="password">
				<span class="wpcf7-form-control-wrap">
					<input type="text" name="pass1" id="pass1" size="16" value="" autocomplete="off" placeholder="Update Password" /><br /><br />
					<input type="text" name="pass2" id="pass2" size="16" value="" autocomplete="off" placeholder="Re-enter Password" />&nbsp;<em><span class="wpcf7-form-control-wrap" class="description"><?php /*_e('Type your new password again.', 'fep');*/ ?></span></em>
					
					<?php if ($show_pass_indicator):?>
					
					<div id="pass-strength"><?php _e('Strength indicator', 'fep'); ?></div>
					<?php endif; ?>
					
					<?php if ($show_pass_hint):?>
					<p class="description indicator-hint">
					<?php 
                    $passhint = get_option('fep_text_pass_hint');

                    if (!empty($passhint)) {
                        echo $passhint;
                    } else {
                        ?>
							-&nbsp;<?php _e('The password should be at least seven characters long.', 'fep');
                        ?><br />
							-&nbsp;<?php _e('To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).', 'fep');
                        ?>
					<?php

                    }
                    ?>
					</p>
					<?php endif; ?>
				</span>
			</p>
			<?php endif; ?>
			</div>

			<?php
                do_action('show_user_profile', $profileuser);
            ?>

			<?php if (count($profileuser->caps) > count($profileuser->roles) && apply_filters('additional_capabilities_display', true, $profileuser)) {
    ?>
			<br class="clear" />
				<div class="wpcf7-form">
					<p>
						<h3 scope="row"><?php _e('Additional Capabilities', 'fep') ?></th>
						<span class="wpcf7-form-control-wrap"><?php
                        $output = '';
    foreach ($profileuser->caps as $cap => $value) {
        if (!$wp_roles->is_role($cap)) {
            if ($output != '') {
                $output .= ', ';
            }
            $output .= $value ? $cap : "Denied: {$cap}";
        }
    }
    echo $output;
    ?></span>
					</p>
				</div>
			<?php 
} ?>

			<p class="wpcf7-form">
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr($user_id); ?>" />
				<br /><br />
				<input type="submit" class="wpcf7-form-control wpcf7-submit" value="<?php _e('Update Profile', 'fep'); ?>" name="submit" />
			</p>
			</form>
		</div>
		
		<script type="text/javascript" charset="utf-8">
			if (window.location.hash == '#password') {
				document.getElementById('pass1').focus();
			}
		</script>
