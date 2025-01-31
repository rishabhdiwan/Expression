<?php
// Theme Enqueue //
function expression_enqueue() {
    wp_enqueue_script('custom-scipt', get_template_directory_uri() . '/assets/build/js/index.min.js', array('jquery'), 1.0, true);
    wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/assets/build/css/style.min.css');
}
add_action('wp_enqueue_scripts', 'expression_enqueue');

// Enabling Thumbnails //
add_theme_support('post-thumbnails');

// Menu Activation //
function theme_register_menus() {
    register_nav_menus(array(
        'primary_menu' => __('Primary Menu'),
    ));
}
add_action('init', 'theme_register_menus');

// Register Form Submission //
function handle_custom_registration() {
    if ( isset($_POST['user_login']) && isset($_POST['user_email']) && isset($_POST['password']) ) {
        
        // Sanitize and gather the form data
        $username = sanitize_text_field($_POST['user_login']);
        $email = sanitize_email($_POST['user_email']);
        $password = sanitize_text_field($_POST['password']);
        $name = sanitize_text_field($_POST['name']);
        $phone = sanitize_text_field($_POST['user_phone']);

        // Check if username or email already exists
        if ( username_exists($username) || email_exists($email) ) {
            echo 'Error: Username or Email already exists!';
            return;
        }

        // Create the user
        $user_id = wp_create_user($username, $password, $email);

        if ( ! is_wp_error($user_id) ) {
            // Update additional user meta (like Name and Phone)
            wp_update_user(array(
                'ID' => $user_id,
                'display_name' => $name
            ));
            update_user_meta($user_id, 'phone', $phone);

            // Set the user role to Author
            $user = new WP_User($user_id);
            $user->set_role('author');
            
            // Optionally log the user in after registration
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);

            // Redirect or show success message
            wp_redirect(home_url()); // Redirect to home page after success
            exit();
        } else {
            // Error handling
            echo 'Error: Unable to create user';
        }
    }
}

// Hook the registration handler to the 'init' action
add_action('init', 'handle_custom_registration');

// Handle custom registration form submission URL
function custom_register_rewrite_rule() {
    add_rewrite_rule('^register-submit/?$', 'index.php?register-submit=1', 'top');
}
add_action('init', 'custom_register_rewrite_rule');

// Handle the rewrite query and call the custom registration function
function handle_register_query_var($query_vars) {
    if (isset($query_vars['register-submit']) && $query_vars['register-submit'] == 1) {
        handle_custom_registration();
        exit;
    }
    return $query_vars;
}
add_filter('query_vars', 'handle_register_query_var');

// Handle custom login form submission //
function handle_custom_login() {
    if ( isset($_POST['log']) && isset($_POST['pwd']) ) {
        // Sanitize and gather the form data
        $username = sanitize_text_field($_POST['log']);
        $password = sanitize_text_field($_POST['pwd']);

        // Authenticate the user
        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true
        );

        $user = wp_signon( $creds, false );

        if ( is_wp_error($user) ) {
            // Handle error: invalid login
            echo 'Error: Invalid Username or Password!';
            return;
        } else {
            // Successful login
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);

            // Redirect to home or dashboard after login
            wp_redirect(home_url()); // Redirect to the homepage (or dashboard)
            exit();
        }
    }
}

// Hook the login handler to the 'init' action
add_action('init', 'handle_custom_login');

// Handle custom login form submission URL
function custom_login_rewrite_rule() {
    add_rewrite_rule('^login-submit/?$', 'index.php?login-submit=1', 'top');
}
add_action('init', 'custom_login_rewrite_rule');

// Handle the rewrite query and call the custom login function
function handle_login_query_var($query_vars) {
    if (isset($query_vars['login-submit']) && $query_vars['login-submit'] == 1) {
        handle_custom_login();
        exit;
    }
    return $query_vars;
}
add_filter('query_vars', 'handle_login_query_var');
