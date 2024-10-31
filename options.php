<?php defined( 'ABSPATH' ) or die; ?>
<div class="wrap wrap-pa-code">
	<div id="icon-themes" class="icon32"></div>
	<?php settings_errors(); ?>
	<img class="pa-code-logo" src="<?php esc_attr_e( $this->logo_url ); ?>" />
	<!--h1><?php _e( 'PrivateAnalytix - Settings', 'privateanalytix' ); ?></h1-->
	<h2 class="nav-tab-wrapper">
		<a href="#" class="nav-tab nav-tab-active"><?php _e( 'Pixel', 'privateanalytix' ); ?></a>
		<a href="<?php esc_attr_e( $this->dashboard_url ); ?>" class="nav-tab" target="_blank"><?php _e( 'My Account', 'privateanalytix' ); ?></a>
	</h2>
	<div class="pa-code-tab">
		<form method="POST" action="options.php">
			<?php settings_fields( 'privateanalytix_optsgroup' ); ?>
			<?php do_settings_sections( 'privateanalytix_optsgroup' ); ?>
			<div class="pa-code-text-center">
				<p><?php _e( 'Paste your PrivateAnalytix code', 'privateanalytix' ); ?></p>
				<div class="pa-code-valign">
					<textarea type="text" name="privateanalytix_code" class="pa-code-input" rows="5"><?php echo esc_textarea( $code ); ?></textarea>
					<?php if ( $code != '' && $is_valid ) : ?>
						<span class="pa-code-check">&check;</span>
					<?php endif; ?>
				</div>
				<?php if ( $code != '' && ! $is_valid ) : ?>
					<p class="pa-code-error"><?php _e( 'Please check the pixel code and try again', 'privateanalytix' ); ?></p>
				<?php endif; ?>
				<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save', 'privateanalytix' ); ?>" />
			</div>
		</form>
	</div>
</div>