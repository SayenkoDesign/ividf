<?php
require_once __DIR__ . '/vendor/autoload.php';
/**
 * Plugin Name: IVIDF User Sign Up
 * Plugin URI: http://sayenkodesign.com
 * Description: Signup users on ivin.intvin.com with their api
 * Version: 1.0
 * Author: Sayenko Design
 */
use GuzzleHttp\Exception\ClientException;

/**
 * WordPress dependencies
 */
global $wpdb;
$dbdelta = function($schema) {
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    \dbDelta($schema);
};
$base_url = WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) );

/**
 * Create Lib Dependencies
 */
$loader = new \Twig_Loader_Filesystem([__DIR__ . '/views']);
$twig = new \Twig_Environment($loader, [
    'debug' => false,
    'cache' => false,
    'auto_reload' => true,
    'strict_variables' => true,
]);

/**
 * other variable
 */
$plugin_url = WP_PLUGIN_URL."/".dirname(plugin_basename(__FILE__));

$dev_url = "https://ivin.ivinchronus.com/api/v1/";
$dev_api = "wEdvVCxvpHt32by6zTkKGg";

$prod_url = "https://ivin.intven.com/api/v1/";
$prod_api = "gjUoTsNRALAEVmGXaYDHsA";

$debug = get_option('ividf_debug');
$api_url = $debug ? $dev_url : $prod_url;
$api_key = $debug ? $dev_api : $prod_api;

/**
 * add menu
 */
add_action('admin_menu', function() use($twig) {
    add_menu_page(
        'IVIDF Signup Settings',
        'IVIDF Signup Settings',
        'administrator',
        'ividf-signup-settings',
        function() use($twig) {
            ob_start();
            settings_fields( 'ividf-signup' );
            $settings_fields = ob_get_clean();
            ob_start();
            do_settings_sections( 'ividf-signup' );
            $do_settings_sections = ob_get_clean();
            ob_start();
            submit_button();
            $submit_button = ob_get_clean();
            $debug = esc_attr(get_option('ividf_debug'));
            $thanks = esc_attr(get_option('ividf_thanks_url'));

            $data = [
                'settings_fields' => $settings_fields,
                'do_settings_sections' => $do_settings_sections,
                'submit_button' => $submit_button,
                'debug' => $debug,
                'thanks' => $thanks,
            ];
            echo $twig->render('settings.html.twig', $data);
        }
    );
});

/**
 * register settings
 */
add_action('admin_init', function() {
    register_setting( 'ividf-signup', 'ividf_debug' );
    register_setting( 'ividf-signup', 'ividf_thanks_url' );
});

/**
 * shortcode
 */
add_shortcode('ividf_signup', function() use($twig, $api_url, $api_key) {
    if(session_id() == '') {
        session_start();
    }
    // countries
    //try {
        if(isset($_SESSION['ividf_signup']) && $_SESSION['ividf_signup']){
            $errors = $_SESSION['ividf_signup']['errors'];
            $previous = $_SESSION['ividf_signup']['post'];
        } else {
            $errors = [];
            $previous = [];
        }
        return $twig->render('form.html.twig', [
            'countries' => ivin_get_countries($api_url, $api_key),
            'action' => admin_url('admin-post.php'),
            'nonce' => wp_nonce_field('ivin_signup', '_wpnonce', true, false),
            'errors' => $errors,
            'previous' => $previous,
        ]);
   // } catch (\Exception $e) {
   //     return "<div class='signup failure'>" . __("There was an error in retrieving the form. Please try again later.")  . "</div>";
   // }
});


add_shortcode('ividf_list', function() use($twig, $api_url, $api_key) {
    $client = new GuzzleHttp\Client([
        'verify' => false,
        'base_uri' => $api_url,
    ]);

    //try{
        $res = $client->request('GET', 'invention_requests.json', [
            'query' => ['api_key' => $api_key]
        ]);

        $data = ['patents' => json_decode((string)$res->getBody())];
        return $twig->render('list.html.twig', $data);
    /*}
    catch (\Exception $e) {
        return __("There was an error in retrieving the patent information. Please try again later.");
    }*/
});

/**
 * add scriptes
 */
add_action('wp_enqueue_scripts', function() use($plugin_url) {
    wp_enqueue_script('validator', $plugin_url.'/web/js/jquery-validation/dist/jquery.validate.min.js', ['jquery']);
    wp_enqueue_script('ivin_signup', $plugin_url.'/web/js/app.js', ['jquery', 'validator']);
    wp_enqueue_style('ivin_signup', $plugin_url.'/web/css/app.css');
    wp_localize_script('ivin_signup', 'ivin_signup', [
        'url' => admin_url('admin-ajax.php'),
        'action' => 'ivin_signup_email_check'
    ]);
});

/**
 * get array of countries
 * @param $api_url
 * @param $api_key
 * @return array|mixed|object
 */
function ivin_get_countries($api_url, $api_key) {
    $client = new GuzzleHttp\Client([
        'verify' => false,
        'base_uri' => $api_url,
    ]);

    $res = $client->request('GET', 'countries.json', [
        'query' => ['api_key' => $api_key]
    ]);

    return json_decode((string) $res->getBody());
}

/**
 * create user via api
 * @param $api_url
 * @param $api_key
 * @param $first_name
 * @param $last_name
 * @param $email
 * @param $country
 * @param $password
 * @param $password_confirmation
 * @param $worked
 * @return string
 */
function ivin_create_user($api_url, $api_key, $first_name, $last_name, $email, $country, $password, $password_confirmation, $worked, $invention_ids) {
    $client = new GuzzleHttp\Client([
        'verify' => false,
        'base_uri' => $api_url,
    ]);
    try {
        $res = $client->request('POST', 'users.json', [
            'query' => ['api_key' => $api_key],
            'form_params' => [
                'first_name'   => $first_name,
                'last_name'    => $last_name,
                'email'        => $email,
                'home_country' => $country,
                'password' => $password,
                'password_confirmation' => $password_confirmation,
                'worked_before' => $worked,
                'invention_ids' => $invention_ids
            ]
        ]);
        return $res;
    } catch (ClientException $e) {
        return $e->getResponse();
    }
}

/**
 * @param $nonce
 * @param $first_name
 * @param $last_name
 * @param $email
 * @param $country
 * @param $password
 * @param $password_confirmation
 * @param $worked
 * @return array
 */
function ivin_validate_form($nonce, $first_name, $last_name, $email, $country, $password, $password_confirmation, $worked, $invention_ids) {
    $verified = wp_verify_nonce($nonce, 'ivin_signup');

    if (!$verified) {
        wp_die(__("The form has expired. Please go back and try again."));
    }

    $errors = [];

    if (!$first_name) {
        $errors['first_name'] = __("Your first name is required");
    }

    if (!$last_name) {
        $errors['last_name'] = __("Your last name is required");
    }

    if (!$last_name) {
        $errors['email'] = __("Your email is required");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = __("Email is invalid");
    }

    if (!$country) {
        $errors['home_country'] = __("Your last name is required");
    } elseif (false) {
        $errors['home_country'] = __("Country is invalid");
    }

    if (!$password) {
        $errors['password'] = __("Password is required");
    } elseif (strlen($password) < 8) {
        $errors['password'] = __("Password must be at least 8 characters long");
    } elseif (preg_match("/\\d/", $password) == 0 || preg_match("/[a-z]/", $password) == 0 || preg_match("/[A-Z]/", $password) == 0) {
        $errors['password'] = __("Password must contain a number, lower case letter and a upper case letter");
    }

    if ($password_confirmation != $password) {
        $errors['password_confirmation'] = __("Passwords do not match");
    }

    return $errors;
}

/**
 * process form
 * @param $api_url
 * @param $api_key
 * @return string|void
 */
function ivin_process_signup($api_url, $api_key)
{
    if(session_id() == '') {
        session_start();
    }

    $nonce = $_POST['_wpnonce'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $country = $_POST['home_country'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    $worked = isset($_POST['worked_before']) && (bool) $_POST['worked_before'] ? 1 : 0;
    $invention_ids = $_POST['invention_ids'];

    $errors = ivin_validate_form($nonce, $first_name, $last_name, $email, $country, $password, $password_confirmation, $worked, $invention_ids);

    if(count($errors)) {
        echo json_encode([
            'status' => 0,
            'errors' => $errors,
        ]);
        return;
    }

    $response = ivin_create_user($api_url, $api_key, $first_name, $last_name, $email, $country, $password, $password_confirmation, $worked, $invention_ids);
    if($response->getStatusCode() == 200) {
        if(isset($_SESSION['ividf_signup'])){
            unset($_SESSION['ividf_signup']);
        }
        if(get_option('ividf_thanks_url')) {
            wp_redirect(get_option('ividf_thanks_url'));
            exit;
        } else {
            wp_die(__("Signed up successfully. please check your email for more information"));
        }
    }
    $_SESSION['ividf_signup'] = [
        'errors' => json_decode((string) $response->getBody())->errors,
        'post' => $_POST,
    ];
    wp_redirect( wp_get_referer() );
    exit;
}
add_action('admin_post_nopriv_ivin_signup', function() use($api_url, $api_key){ivin_process_signup($api_url, $api_key);});
add_action('admin_post_ivin_signup', function() use($api_url, $api_key){ivin_process_signup($api_url, $api_key);});

function ivin_email_check($api_url, $api_key) {
    $email = $_POST['email'];
    $client = new GuzzleHttp\Client([
        'verify' => false,
        'base_uri' => $api_url,
    ]);
    try {
        $response = $client->request('GET', 'emails/validate.json', [
            'query' => ['api_key' => $api_key],
            'form_params' => [
                'email' => $email,
            ]
        ]);
    } catch (ClientException $e) {
        $response = $e->getResponse();
    }

    header('Content-Type: application/json');
    if($response->getStatusCode() == 200) {
        $data = json_decode((string) $response->getBody());
        echo $data->valid ? "true" : "false";
    } else {
        echo "false";
    }
    exit;
    
}
add_action('wp_ajax_nopriv_ivin_signup_email_check', function() use($api_url, $api_key){ivin_email_check($api_url, $api_key);});
add_action('wp_ajax_ivin_signup_email_check', function() use($api_url, $api_key){ivin_email_check($api_url, $api_key);});