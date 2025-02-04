<?php
get_header();
/* Template Name: User Dashboard */
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login')); // Redirect non-logged-in users
    exit;
}
$current_user = wp_get_current_user();

// Include the necessary admin file to use media functions on the frontend
if (!function_exists('media_handle_upload')) {
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_post'])) {
    $title = sanitize_text_field($_POST['post_title']);
    $content = wp_kses_post($_POST['post_content']);
    $featured_image = $_FILES['post_thumbnail'];

    // Check if title, content, and featured image are provided
    if (!empty($title) && !empty($content) && !empty($featured_image['name'])) {        
        $uploaded_image = media_handle_upload('post_thumbnail', 0);
        if (is_wp_error($uploaded_image)) {
            echo "<p>Error uploading the featured image. Please try again.</p>";
        } else {
            // Create the post
            $new_post = array(
                'post_title'    => $title,
                'post_content'  => $content,
                'post_status'   => 'pending', // Set to 'publish' if you want immediate publication
                'post_author'   => $current_user->ID,
                'post_type'     => 'blogging-expression', // Custom post type
                'meta_input'    => array(
                    '_thumbnail_id' => $uploaded_image, // Set featured image
                ),
            );

            $post_id = wp_insert_post($new_post);
            if ($post_id) {
                echo "<p>Post submitted successfully.</p>";
            }
        }
    } else {
        echo "<p>Please fill in all fields including the featured image.</p>";
    }
}
?>
<div class="container">
    <h2>Welcome, <?php echo esc_html($current_user->display_name); ?>! This is you personal Dashboard.</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="post_title" placeholder="Post Title" required>
        <textarea name="post_content" placeholder="Post Content" required></textarea>
        <label for="post_thumbnail" class="custom-image-upload">Add Featured Image</label>
        <input type="file" name="post_thumbnail" id="post_thumbnail" accept="image/*" style="display:none;" required>
        <button type="submit" name="submit_post" class="user-dashboard-form-submit">Submit Post</button>
    </form>
</div>
<?php
get_footer();
?>
