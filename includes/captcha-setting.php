<?php
/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * custom option and settings
 */
function dmc_settings_init() {
    // Register a new setting for "dmc" page.
    register_setting( 'dmc', 'dmc_options' );

    // Register a new section in the "dmc" page.
    add_settings_section(
        'dmc_section_developers',
        __( 'Google Captcha Settings.', 'dmc' ), 'dmc_section_developers_callback',
        'dmc'
    );

    // Register a new field in the "dmc_section_developers" section, inside the "dmc" page.
    add_settings_field(
        'dmc_field_site_key', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Google Site Key', 'dmc' ),
        'dmc_field_site_key_cb',
        'dmc',
        'dmc_section_developers',
        array(
            'label_for'         => 'dmc_field_site_key',
            'class'             => 'dmc_row',
            'dmc_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'dmc_field_secret', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Google Captcha Secret', 'dmc' ),
        'dmc_field_secret_cb',
        'dmc',
        'dmc_section_developers',
        array(
            'label_for'         => 'dmc_field_secret',
            'class'             => 'dmc_row',
            'dmc_custom_data' => 'custom',
        )
    );
}

/**
 * Register our dmc_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'dmc_settings_init' );


/**
 * Custom option and settings:
 *  - callback functions
 */


/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function dmc_section_developers_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( '', 'dmc' ); ?></p>
    <?php
}

/**
 * currency field callbakc function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function dmc_field_site_key_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'dmc_options' );
    ?>

    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="dmc_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $options[ $args['label_for'] ] ); ?>">

    <?php
}

function dmc_field_secret_cb( $args ){
    $options = get_option( 'dmc_options' );
    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="dmc_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $options[ $args['label_for'] ] ); ?>">
    <?php
}

/**
 * Add the top level menu page.
 */
function dmc_options_page() {
    add_menu_page(
        'Google Captcha Settings',
        'Google Captcha Settings',
        'manage_options',
        'dmc',
        'dmc_options_page_html'
    );
}


/**
 * Register our dmc_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'dmc_options_page' );


/**
 * Top level menu callback function
 */
function dmc_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'dmc_messages', 'dmc_message', __( 'Settings Saved', 'dmc' ), 'updated' );
    }

    // show error/update messages
    settings_errors( 'dmc_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "dmc"
            settings_fields( 'dmc' );
            // output setting sections and their fields
            // (sections are registered for "dmc", each field is registered to a specific section)
            do_settings_sections( 'dmc' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}