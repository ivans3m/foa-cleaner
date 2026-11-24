<?php
/**
 * Optional Recommended Plugins onboarding panel and AJAX plugin helpers.
 *
 * Provides a clean, non-intrusive panel inside Appearance → FoA Cleaner with
 * progressive Install → Activate → Active controls using WordPress core APIs,
 * plus a single dismissible welcome notice on theme activation.
 *
 * @package FoA_Cleaner
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the allowlisted catalog of optional recommended plugins.
 *
 * All plugins listed here are strictly optional and hosted on WordPress.org.
 *
 * @since 1.1.0
 *
 * @return array<string, array{slug: string, file: string, name: string, summary: string, wp_org_url: string}>
 */
function foa_cleaner_get_recommended_plugins(): array {
	return array(
		'vibetiles' => array(
			'slug'       => 'vibetiles',
			'file'       => 'vibetiles/vibetiles.php',
			'name'       => __( 'Vibetiles', 'foa-cleaner' ),
			'summary'    => __( 'Live color palettes, typography, and light/dark style exploration for visitors and site owners. FoA Cleaner automatically hands off color switching when active.', 'foa-cleaner' ),
			'wp_org_url' => 'https://wordpress.org/plugins/vibetiles/',
		),
		'jetpack'   => array(
			'slug'       => 'jetpack',
			'file'       => 'jetpack/jetpack.php',
			'name'       => __( 'Jetpack', 'foa-cleaner' ),
			'summary'    => __( 'Optional companion for Portfolio Projects (jetpack-portfolio) and the Markdown block for structured CV and documentation pages.', 'foa-cleaner' ),
			'wp_org_url' => 'https://wordpress.org/plugins/jetpack/',
		),
	);
}

/**
 * Check whether the Jetpack plugin is currently active.
 *
 * @since 1.1.0
 *
 * @return bool True when Jetpack is active.
 */
function foa_cleaner_is_jetpack_active(): bool {
	return defined( 'JETPACK__VERSION' )
		|| class_exists( 'Jetpack' )
		|| class_exists( 'Automattic\Jetpack\Classic_Theme_Helper\Jetpack_Portfolio' );
}

/**
 * Resolve installation and activation state for a recommended plugin.
 *
 * @since 1.1.0
 *
 * @param string $slug         WordPress.org plugin directory slug.
 * @param string $default_file Expected plugin basename (e.g. `jetpack/jetpack.php`).
 * @return array{status: string, file: string} Status is 'active', 'installed', or 'not_installed'.
 */
function foa_cleaner_get_plugin_status( string $slug, string $default_file ): array {
	if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$installed = get_plugins();
	$file      = $default_file;

	if ( ! isset( $installed[ $file ] ) ) {
		$prefix = trailingslashit( $slug );
		foreach ( array_keys( $installed ) as $candidate ) {
			if ( 0 === strpos( $candidate, $prefix ) ) {
				$file = $candidate;
				break;
			}
		}
	}

	if ( isset( $installed[ $file ] ) ) {
		if ( is_plugin_active( $file ) ) {
			return array(
				'status' => 'active',
				'file'   => $file,
			);
		}

		return array(
			'status' => 'installed',
			'file'   => $file,
		);
	}

	return array(
		'status' => 'not_installed',
		'file'   => $default_file,
	);
}

/**
 * Build a progressive-enhancement WordPress admin action URL for installing
 * or activating a plugin (used as non-JS fallback alongside AJAX).
 *
 * @since 1.1.0
 *
 * @param string $slug        Plugin slug.
 * @param string $plugin_file Plugin basename.
 * @param string $status      Current status ('not_installed' or 'installed').
 * @return string Admin action URL, or empty string if unavailable.
 */
function foa_cleaner_get_plugin_action_url( string $slug, string $plugin_file, string $status ): string {
	if ( 'not_installed' === $status && current_user_can( 'install_plugins' ) ) {
		return wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'install-plugin',
					'plugin' => $slug,
				),
				self_admin_url( 'update.php' )
			),
			'install-plugin_' . $slug
		);
	}

	if ( 'installed' === $status && current_user_can( 'activate_plugins' ) ) {
		return wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'activate',
					'plugin' => $plugin_file,
				),
				self_admin_url( 'plugins.php' )
			),
			'activate-plugin_' . $plugin_file
		);
	}

	return '';
}

/**
 * Render an inline Install/Activate Jetpack link next to a disabled integration checkbox.
 *
 * @since 1.1.0
 */
function foa_cleaner_render_jetpack_inline_action(): void {
	$state  = foa_cleaner_get_plugin_status( 'jetpack', 'jetpack/jetpack.php' );
	$status = $state['status'];

	if ( 'active' === $status ) {
		return;
	}

	$url = foa_cleaner_get_plugin_action_url( 'jetpack', $state['file'], $status );

	if ( 'not_installed' === $status && '' !== $url ) {
		printf(
			' <a href="%1$s" class="foa-inline-plugin-action" data-foa-plugin-action="install" data-slug="jetpack" data-plugin-file="%2$s" data-reload-on-activate="1">%3$s</a>',
			esc_url( $url ),
			esc_attr( $state['file'] ),
			esc_html__( 'Install Jetpack', 'foa-cleaner' )
		);
		return;
	}

	if ( 'installed' === $status && '' !== $url ) {
		printf(
			' <a href="%1$s" class="foa-inline-plugin-action" data-foa-plugin-action="activate" data-slug="jetpack" data-plugin-file="%2$s" data-reload-on-activate="1">%3$s</a>',
			esc_url( $url ),
			esc_attr( $state['file'] ),
			esc_html__( 'Activate Jetpack', 'foa-cleaner' )
		);
		return;
	}

	echo ' <span class="foa-inline-plugin-muted">' . esc_html__( '(Requires Jetpack)', 'foa-cleaner' ) . '</span>';
}

/**
 * Render the Recommended Plugins panel on the Appearance → FoA Cleaner screen.
 *
 * @since 1.1.0
 */
function foa_cleaner_render_recommended_plugins_panel(): void {
	$plugins = foa_cleaner_get_recommended_plugins();
	?>
	<section class="foa-admin-panel" aria-labelledby="foa-recommended-plugins-heading">
		<div class="foa-admin-panel__header">
			<div>
				<h2 id="foa-recommended-plugins-heading" class="foa-admin-panel__title"><?php esc_html_e( 'Recommended Companion Plugins', 'foa-cleaner' ); ?></h2>
				<p class="foa-admin-panel__subtitle"><?php esc_html_e( 'FoA Cleaner works completely standalone with zero required plugins. Install any optional companion below to unlock extra workflows.', 'foa-cleaner' ); ?></p>
			</div>
		</div>

		<div class="foa-plugin-grid">
			<?php foreach ( $plugins as $plugin ) : ?>
				<?php
				$state  = foa_cleaner_get_plugin_status( $plugin['slug'], $plugin['file'] );
				$status = $state['status'];
				$url    = foa_cleaner_get_plugin_action_url( $plugin['slug'], $state['file'], $status );
				$reload = 'jetpack' === $plugin['slug'] ? '1' : '0';
				?>
				<div class="foa-plugin-card" data-foa-plugin-card="<?php echo esc_attr( $plugin['slug'] ); ?>">
					<div class="foa-plugin-card__top">
						<h3 class="foa-plugin-card__name">
							<a href="<?php echo esc_url( $plugin['wp_org_url'] ); ?>" target="_blank" rel="noopener noreferrer">
								<?php echo esc_html( $plugin['name'] ); ?>
							</a>
						</h3>
						<?php if ( 'active' === $status ) : ?>
							<span class="foa-plugin-badge is-active" data-foa-plugin-badge><?php esc_html_e( 'Active', 'foa-cleaner' ); ?></span>
						<?php elseif ( 'installed' === $status ) : ?>
							<span class="foa-plugin-badge is-installed" data-foa-plugin-badge><?php esc_html_e( 'Installed', 'foa-cleaner' ); ?></span>
						<?php else : ?>
							<span class="foa-plugin-badge is-optional" data-foa-plugin-badge><?php esc_html_e( 'Optional', 'foa-cleaner' ); ?></span>
						<?php endif; ?>
					</div>

					<p class="foa-plugin-card__desc"><?php echo esc_html( $plugin['summary'] ); ?></p>

					<div class="foa-plugin-card__actions">
						<?php if ( 'active' === $status ) : ?>
							<span class="foa-plugin-active-note"><?php esc_html_e( 'Installed and active.', 'foa-cleaner' ); ?></span>
						<?php elseif ( 'installed' === $status && '' !== $url ) : ?>
							<a
								href="<?php echo esc_url( $url ); ?>"
								class="button button-primary"
								data-foa-plugin-action="activate"
								data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>"
								data-plugin-file="<?php echo esc_attr( $state['file'] ); ?>"
								data-reload-on-activate="<?php echo esc_attr( $reload ); ?>"
							>
								<?php esc_html_e( 'Activate', 'foa-cleaner' ); ?>
							</a>
						<?php elseif ( 'not_installed' === $status && '' !== $url ) : ?>
							<a
								href="<?php echo esc_url( $url ); ?>"
								class="button button-secondary"
								data-foa-plugin-action="install"
								data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>"
								data-plugin-file="<?php echo esc_attr( $state['file'] ); ?>"
								data-reload-on-activate="<?php echo esc_attr( $reload ); ?>"
							>
								<?php esc_html_e( 'Install', 'foa-cleaner' ); ?>
							</a>
						<?php else : ?>
							<span class="foa-plugin-active-note"><?php esc_html_e( 'Ask a site administrator to install or activate this plugin.', 'foa-cleaner' ); ?></span>
						<?php endif; ?>
						<span class="foa-plugin-card__message" role="status" aria-live="polite" data-foa-plugin-message></span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

/**
 * Enqueue lightweight admin CSS/JS only on the Appearance → FoA Cleaner page.
 *
 * @since 1.1.0
 *
 * @param string $hook_suffix Current admin screen hook suffix.
 */
function foa_cleaner_enqueue_admin_options_assets( string $hook_suffix ): void {
	if ( 'appearance_page_foa-cleaner-options' !== $hook_suffix ) {
		return;
	}

	wp_enqueue_style(
		'foa-cleaner-admin-options',
		get_theme_file_uri( 'assets/css/admin-options.css' ),
		array(),
		foa_cleaner_asset_version( 'assets/css/admin-options.css' )
	);

	wp_enqueue_script(
		'foa-cleaner-admin-options',
		get_theme_file_uri( 'assets/js/admin-options.js' ),
		array( 'updates' ),
		foa_cleaner_asset_version( 'assets/js/admin-options.js' ),
		true
	);

	wp_add_inline_script(
		'foa-cleaner-admin-options',
		'window.foaCleanerAdmin = ' . wp_json_encode(
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'foa_cleaner_plugin_action' ),
				'cvNonce' => wp_create_nonce( 'foa_cleaner_cv_action' ),
				'labels'  => array(
					'installing'      => __( 'Installing…', 'foa-cleaner' ),
					'activating'      => __( 'Activating…', 'foa-cleaner' ),
					'activate'        => __( 'Activate', 'foa-cleaner' ),
					'activateJp'      => __( 'Activate Jetpack', 'foa-cleaner' ),
					'active'          => __( 'Active', 'foa-cleaner' ),
					'installed'       => __( 'Installed', 'foa-cleaner' ),
					'activeNote'      => __( 'Installed and active.', 'foa-cleaner' ),
					'reloading'       => __( 'Activated. Reloading settings…', 'foa-cleaner' ),
					'installError'    => __( 'Installation failed. Try again from Plugins → Add New.', 'foa-cleaner' ),
					'activateError'   => __( 'Activation failed. Try activating from the Plugins screen.', 'foa-cleaner' ),
					'cvCreating'      => __( 'Creating Draft…', 'foa-cleaner' ),
					'cvCreateSubmit'  => __( 'Create Draft CV Page', 'foa-cleaner' ),
					'cvCreateError'   => __( 'Could not create CV page. Check that your Markdown file is valid UTF-8.', 'foa-cleaner' ),
					'cvPublishing'    => __( 'Publishing…', 'foa-cleaner' ),
					'cvPublish'       => __( 'Publish', 'foa-cleaner' ),
					'cvPublished'     => __( 'Published', 'foa-cleaner' ),
					'cvView'          => __( 'View', 'foa-cleaner' ),
					'cvPublishError'  => __( 'Could not publish the CV page.', 'foa-cleaner' ),
					'cvDeleteConfirm' => __( 'Move this CV page to Trash? You can restore it from Pages → Trash or upload a new CV immediately.', 'foa-cleaner' ),
					'cvDeleting'      => __( 'Moving to Trash…', 'foa-cleaner' ),
					'cvDelete'        => __( 'Delete', 'foa-cleaner' ),
					'cvDeleteError'   => __( 'Could not move the CV page to Trash.', 'foa-cleaner' ),
				),
			)
		) . ';',
		'before'
	);
}
add_action( 'admin_enqueue_scripts', 'foa_cleaner_enqueue_admin_options_assets' );

/**
 * AJAX handler to activate an allowlisted recommended plugin.
 *
 * @since 1.1.0
 */
function foa_cleaner_ajax_activate_plugin(): void {
	check_ajax_referer( 'foa_cleaner_plugin_action', 'nonce' );

	if ( ! current_user_can( 'activate_plugins' ) ) {
		wp_send_json_error(
			array( 'message' => __( 'You do not have permission to activate plugins.', 'foa-cleaner' ) ),
			403
		);
	}

	$slug    = isset( $_POST['slug'] ) ? sanitize_key( wp_unslash( $_POST['slug'] ) ) : '';
	$catalog = foa_cleaner_get_recommended_plugins();

	if ( '' === $slug || ! isset( $catalog[ $slug ] ) ) {
		wp_send_json_error(
			array( 'message' => __( 'Unsupported plugin slug.', 'foa-cleaner' ) ),
			400
		);
	}

	$state = foa_cleaner_get_plugin_status( $slug, $catalog[ $slug ]['file'] );

	if ( 'not_installed' === $state['status'] ) {
		wp_send_json_error(
			array( 'message' => __( 'Plugin is not installed yet.', 'foa-cleaner' ) ),
			400
		);
	}

	if ( 'active' === $state['status'] ) {
		wp_send_json_success(
			array(
				'slug'   => $slug,
				'status' => 'active',
			)
		);
	}

	$result = activate_plugin( $state['file'] );

	if ( is_wp_error( $result ) ) {
		wp_send_json_error(
			array( 'message' => $result->get_error_message() ),
			500
		);
	}

	wp_send_json_success(
		array(
			'slug'   => $slug,
			'status' => 'active',
		)
	);
}
add_action( 'wp_ajax_foa_cleaner_activate_plugin', 'foa_cleaner_ajax_activate_plugin' );

/**
 * Reset the one-time welcome notice state when FoA Cleaner is freshly activated.
 *
 * @since 1.1.0
 */
function foa_cleaner_on_theme_switch(): void {
	$user_id = get_current_user_id();
	if ( $user_id > 0 ) {
		delete_user_meta( $user_id, 'foa_cleaner_dismissed_welcome' );
	}
}
add_action( 'after_switch_theme', 'foa_cleaner_on_theme_switch' );

/**
 * Show a single, polite, dismissible welcome notice on Themes & Dashboard screens
 * after theme activation, linking to Appearance → FoA Cleaner.
 *
 * @since 1.1.0
 */
function foa_cleaner_welcome_notice(): void {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || ! in_array( $screen->id, array( 'themes', 'dashboard' ), true ) ) {
		return;
	}

	$user_id = get_current_user_id();
	if ( $user_id <= 0 || get_user_meta( $user_id, 'foa_cleaner_dismissed_welcome', true ) ) {
		return;
	}

	$settings_url = admin_url( 'themes.php?page=foa-cleaner-options' );
	$nonce        = wp_create_nonce( 'foa_cleaner_dismiss_welcome' );
	?>
	<div class="notice notice-info is-dismissible foa-welcome-notice" data-foa-dismiss-nonce="<?php echo esc_attr( $nonce ); ?>">
		<p>
			<strong><?php esc_html_e( 'Welcome to FoA Cleaner.', 'foa-cleaner' ); ?></strong>
			<?php esc_html_e( 'Configure default light/dark mode, micro-animations, and optional companion plugins (Vibetiles, Jetpack) in theme settings.', 'foa-cleaner' ); ?>
			<a href="<?php echo esc_url( $settings_url ); ?>" class="button button-secondary" style="margin-left:8px;vertical-align:baseline;"><?php esc_html_e( 'Open FoA Cleaner Settings', 'foa-cleaner' ); ?></a>
		</p>
	</div>
	<?php
	wp_print_inline_script_tag(
		'(function(){var n=document.querySelector(".foa-welcome-notice");if(!n)return;n.addEventListener("click",function(e){if(!e.target.closest(".notice-dismiss"))return;var b=new URLSearchParams();b.set("action","foa_cleaner_dismiss_welcome");b.set("nonce",n.getAttribute("data-foa-dismiss-nonce")||"");fetch(window.ajaxurl||"/wp-admin/admin-ajax.php",{method:"POST",credentials:"same-origin",headers:{"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},body:b.toString()});});})();',
		array( 'id' => 'foa-cleaner-welcome-dismiss' )
	);
}
add_action( 'admin_notices', 'foa_cleaner_welcome_notice' );

/**
 * Persist dismissal of the one-time welcome notice per user.
 *
 * @since 1.1.0
 */
function foa_cleaner_ajax_dismiss_welcome(): void {
	check_ajax_referer( 'foa_cleaner_dismiss_welcome', 'nonce' );

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_send_json_error( array(), 403 );
	}

	update_user_meta( get_current_user_id(), 'foa_cleaner_dismissed_welcome', 1 );
	wp_send_json_success();
}
add_action( 'wp_ajax_foa_cleaner_dismiss_welcome', 'foa_cleaner_ajax_dismiss_welcome' );
