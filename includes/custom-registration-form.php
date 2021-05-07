<?php

function dm_registration_load_scripts()
{
    wp_enqueue_style('boot_css', plugins_url('css/bootstrap.min.css',__FILE__ ));
    wp_enqueue_script('jquery_js', plugins_url('js/jquery.min.js',__FILE__ ));
    wp_enqueue_script('boot_js', plugins_url('js/bootstrap.min.js',__FILE__ ));
    wp_enqueue_script('action_js', plugins_url('js/action.js',__FILE__ ));
    wp_enqueue_script('gcap_js', "https://www.google.com/recaptcha/api.js");
    wp_localize_script( 'action_js', 'my_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );


}

add_action('wp_enqueue_scripts', 'dm_registration_load_scripts');


function dm_registration_shortcode( $atts ) {
    global $wpdb;
    $opt = get_option('dmc_options');

    $html = '<div class="container">
            <h2>Registration</h2>
                <div class="form-group">
                    <label for="uname">Username:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="uname"
                        name="uname"
                        placeholder="Enter user name"
                    />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="Enter email"
                    />
                </div>

                <div class="form-group">
                    <label for="passwd">Password:</label>
                    <input
                        type="password"
                        class="form-control"
                        id="passwd"
                        name="passwd"
                        placeholder="Enter password"
                    />
                </div>
                <div class="form-group">
                    <label for="sq">Security Question:</label>
                    <textarea class="form-control" name="sq" id="sq"></textarea>
                </div>
                <div class="form-group">
                    <label for="sq">Security Answer:</label>
                    <textarea class="form-control" name="sa" id="sa"></textarea>
                </div>
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="'.$opt['dmc_field_site_key'].'"></div>
                </div>
                <button type="submit" id="submit" class="btn btn-default">Submit</button>
        </div>';

    return $html;
}


?>