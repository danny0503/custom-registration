<?php
include('custom-registration-form.php');
include('user-register.php');
include('captcha-setting.php');

add_shortcode('registration', 'dm_registration_shortcode');

$object_type = 'user';

$args1 = array(
    'type'      => 'string',
    'description'    => 'Security Question',
    'single'        => true,
    'show_in_rest'    => true,
);

$args2 = array(
    'type'      => 'string',
    'description'    => 'Security Answer',
    'single'        => true,
    'show_in_rest'    => true,
);

register_meta( $object_type, 'security_question', $args1 );

register_meta( $object_type, 'security_answer', $args2 );




?>