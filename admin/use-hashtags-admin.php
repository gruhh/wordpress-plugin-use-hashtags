<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register the menu.
 */
function use_hashtags_add_to_menu() {
	add_management_page(
		'Use Hashtags',
		'Use Hashtags',
		'manage_options',
		'use-hashtags',
		'use_hashtags_options_page_html',
		99
	);
}

add_action( 'admin_menu', 'use_hashtags_add_to_menu' );

/**
 * Register the HTML page of admin.
 */
function use_hashtags_options_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
    <div class="wrap">
        <h1>Use Hashtags</h1>
        <form action="options.php" method="post">
			<?php
			settings_fields( 'use-hashtags-settings' );
			do_settings_sections( 'use-hashtags-settings' );
			submit_button( __( 'Save Settings', 'use-hashtags' ) );
			?>
        </form>
    </div>
	<?php
}

/**
 * Register the settings.
 */
function use_hashtags_register_setting() {
	add_settings_section(
		'use_hashtags_settings_contexts',
		esc_attr__( 'Use Context', 'use-hashtags' ),
		'use_hashtags_contexts_callback',
		'use-hashtags-settings'
	);

	add_settings_section(
		'use_hashtags_settings_link',
		esc_attr__( 'Options of the Link', 'use-hashtags' ),
		'use_hashtags_link_callback',
		'use-hashtags-settings'
	);

	add_settings_field(
		'use_in_content_field',
		esc_attr__( 'Use hashtags in Content?', 'use-hashtags' ),
		'use_hashtags_form_use_in_content',
		'use-hashtags-settings',
		'use_hashtags_settings_contexts',
		array(
			'label_for'   => 'usecontent',
			'description' => __( 'Convert #hashtags to search links in the_content.', 'use-hashtags' ),
		)
	);

	add_settings_field(
		'use_in_excerpt_field',
		esc_attr__( 'Use hashtags in Excerpt?', 'use-hashtags' ),
		'use_hashtags_form_use_in_excerpt',
		'use-hashtags-settings',
		'use_hashtags_settings_contexts',
		array(
			'label_for'   => 'useexcerpt',
			'description' => __( 'Convert #hashtags to search links in the_excerpt.', 'use-hashtags' ),
		)
	);

	add_settings_field(
		'link_field',
		esc_attr__( 'Link URL', 'use-hashtags' ),
		'use_hashtags_form_link_url',
		'use-hashtags-settings',
		'use_hashtags_settings_link'
	);

	add_settings_field(
		'link_qualify_field',
		esc_attr__( 'Link Qualify', 'use-hashtags' ),
		'use_hashtags_form_link_qualify',
		'use-hashtags-settings',
		'use_hashtags_settings_link'
	);

	add_settings_field(
		'link_target_field',
		esc_attr__( 'Link Target', 'use-hashtags' ),
		'use_hashtags_form_link_target',
		'use-hashtags-settings',
		'use_hashtags_settings_link'
	);

	add_settings_field(
		'link_class_field',
		esc_attr__( 'Link CSS Class', 'use-hashtags' ),
		'use_hashtags_link_class',
		'use-hashtags-settings',
		'use_hashtags_settings_link'
	);

	register_setting(
		'use-hashtags-settings',
		'use_hashtags_options',
		'use_hashtags_validate'
	);
}

add_action( 'admin_init', 'use_hashtags_register_setting', 'use_hashtags_validate' );

/**
 * Validate the settings content.
 */
function use_hashtags_validate( $input ) {
	$input['use_hashtags_in_content']   = filter_var( $input['use_hashtags_in_content'], FILTER_VALIDATE_BOOLEAN );
	$input['use_hashtags_in_excerpt']   = filter_var( $input['use_hashtags_in_excerpt'], FILTER_VALIDATE_BOOLEAN );
	$input['use_hashtags_link']         = sanitize_text_field( $input['use_hashtags_link'] );
	$input['use_hashtags_link_qualify'] = sanitize_text_field( $input['use_hashtags_link_qualify'] );
	$input['use_hashtags_link_target']  = sanitize_text_field( $input['use_hashtags_link_target'] );

	return $input;
}

/**
 * Description of the Context Section
 */
function use_hashtags_contexts_callback() {
	_e( 'You can enable/disable where the hashtags will be converted.', 'use-hashtags' );
}

/**
 * Description of the Link Section
 */
function use_hashtags_link_callback() {
	_e( 'This is the configuration of the links generation.', 'use-hashtags' );
}

/**
 * Form Field to Context - Content.
 */
function use_hashtags_form_use_in_content( $args ) {
	$options_r = (array) get_option( 'use_hashtags_options' );

	echo '<input type="checkbox" id="usecontent" ' .
	     'name="use_hashtags_options[use_hashtags_in_content]" value="1" ' .
	     checked( 1, $options_r['use_hashtags_in_content'], false ) . '/>';

	echo "<p>{$args['description']}</p>";
}

/**
 * Form Field to Context - Excerpt.
 */
function use_hashtags_form_use_in_excerpt( $args ) {
	$options_r = (array) get_option( 'use_hashtags_options' );

	echo '<input type="checkbox" id="useexcerpt" ' .
	     'name="use_hashtags_options[use_hashtags_in_excerpt]" value="1" ' .
	     checked( 1, $options_r['use_hashtags_in_excerpt'], false ) . '/>';

	echo "<p>{$args['description']}</p>";
}

/**
 * Form Field to Link URL.
 */
function use_hashtags_form_link_url() {
	$options_r = (array) get_option( 'use_hashtags_options' );

	printf(
		'<code>%s/</code><input type="text" id="linkurl" ' .
		'name="use_hashtags_options[use_hashtags_link]" value="%s" /><code>#hashtag</code>',
		site_url(),
		esc_attr( $options_r['use_hashtags_link'] )
	);
}

/**
 * Form Field to Link Qualify.
 */
function use_hashtags_form_link_qualify() {
	$options_r = (array) get_option( 'use_hashtags_options' );

	printf(
		'<code>rel=</code><input type="text" id="linkqualify" ' .
		'name="use_hashtags_options[use_hashtags_link_qualify]" value="%s" />',
		esc_attr( $options_r['use_hashtags_link_qualify'] )
	);
}

/**
 * Form Field to Link Target.
 */
function use_hashtags_form_link_target() {
	$options_r = (array) get_option( 'use_hashtags_options' );

	printf(
		'<code>target=</code><input type="text" id="linktarget" ' .
		'name="use_hashtags_options[use_hashtags_link_target]" value="%s" />',
		esc_attr( $options_r['use_hashtags_link_target'] )
	);
}

/**
 * Pseudo-field to Link CSS Class.
 *
 * This is just to let the user know that a class is added to every link.
 */
function use_hashtags_link_class() {
	echo '<code>hashtag-link</code>';
}

/**
 * Create a Settings link in the plugins list.
 */
function use_hashtags_settings_link( $links ) {
	array_push(
		$links,
		'<a href="tools.php?page=use-hashtags">' . esc_attr__( 'Settings', 'use-hashtags' ) . '</a>' );

	return $links;
}

add_filter( "plugin_action_links_use-hashtags/use-hashtags.php", 'use_hashtags_settings_link' );
