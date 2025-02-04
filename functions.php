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
        $firstname = sanitize_text_field($_POST['firstname']);
        $lastname = sanitize_text_field($_POST['lastname']);
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
                'display_name' => $firstname
            ));
            update_user_meta($user_id, 'first_name', $firstname);
            update_user_meta($user_id, 'last_name', $lastname);
            update_user_meta($user_id, 'phone', $phone);

            // Set the user role to Author
            $user = new WP_User($user_id);
            $user->set_role('author');
            
            // Optionally log the user in after registration
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);

            if ($user) {
                $subject = 'Registration Successful.';
                $message = "Dear $name,\n\nYour have successfully registered with Expression. Now you can start using it to get your feelings and thoughts out in the World. \n\nRegards,\nExpression";
                $headers = ['Content-Type: text/plain; charset=UTF-8'];

                wp_mail($email, $subject, $message, $headers);
            }

            // Redirect or show success message
            wp_redirect(home_url('/?registration=success')); // Redirect to homepage with success message
            exit;
        } else {
            // Error handling
            echo 'Error: Unable to create user';
            wp_redirect(home_url('/?registration=failed')); // Redirect with error
            exit;
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

// Email on Post Publish, Deletion
function send_email_on_publish_blogging_expression($post_ID) {
    // Get the post object
    $post = get_post($post_ID);

    // Check if the post is of type 'blogging-expression'
    if ($post->post_type !== 'blogging-expression') {
        return;
    }

    // Check if it's a new post (not an update)
    if ($post->post_date === $post->post_modified) {
        $user = wp_get_current_user();
        $subject = 'Your Blog Post has been Published';
        $message = 'Hello ' . $user->user_login . ', congratulations! Your blog post titled "' . $post->post_title . '" has been published!';

        $to = $user->user_email;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($to, $subject, $message, $headers);
    }

}
add_action('publish_blogging-expression', 'send_email_on_publish_blogging_expression');

function send_email_on_delete_blogging_expression($post_ID) {
    $post = get_post($post_ID);
    if ($post->post_type !== 'blogging-expression') {
        return;
    }
    $user = wp_get_current_user();
    // Send an email when the post is deleted
    $subject = 'Your Blog Post has been Deleted';
    $message = 'Hello ' . $user->user_login . ', Your blog post titled "' . $post->post_title . '" is deleted.';

    // Send the email
    $to = $user->user_email;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($to, $subject, $message, $headers);
}

add_action('before_delete_post', 'send_email_on_delete_blogging_expression');

function validate_blogging_expression_submission() {
    // Get the current screen
    $screen = get_current_screen();

    // Check if we are editing a post and if it's of type 'blogging-expression'
    if ($screen && $screen->base === 'post' && $screen->post_type === 'blogging-expression') {
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Find the Publish/Update button
                let publishButton = document.querySelector("#publish");

                if (publishButton) {
                    publishButton.addEventListener("click", function(event) {
                        // Get the values from the editor
                        let title = document.getElementById("title").value.trim();
                        let content = document.querySelector("#content").value.trim();
                        let featuredImage = document.querySelector("#set-post-thumbnail img"); // Featured Image Check

                        // Check if fields are missing
                        let missingFields = [];
                        if (!title) missingFields.push("Title");
                        if (!content) missingFields.push("Content");
                        if (!featuredImage) missingFields.push("Featured Image");

                        // If any field is missing, prevent submission
                        if (missingFields.length > 0) {
                            event.preventDefault(); // Stop form submission
                            alert("Please add the following required fields before publishing: " + missingFields.join(", "));
                        }
                    });
                }
            });
        </script>
        <?php
    }
}
add_action('admin_footer', 'validate_blogging_expression_submission');

function redirect_non_admin_users() {
    if (is_admin() && !current_user_can('administrator') && !wp_doing_ajax()) {
        wp_redirect(home_url('/user-dashboard'));
        exit;
    }
}
add_action('init', 'redirect_non_admin_users');
