<?php
get_header();
/* Template Name: User Dashboard */
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
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
                'post_status'   => 'publish',
                'post_author'   => $current_user->ID,
                'post_type'     => 'blogging-expression',
                'meta_input'    => array(
                    '_thumbnail_id' => $uploaded_image,
                ),
            );

            $post_id = wp_insert_post($new_post);
            if ($post_id) : ?>
            <div class="container">
                <p class = "post-submission">Post submitted successfully.</p>
            </div>
            <?php endif; 
        }
    } else {
        echo "<p>Please fill in all fields including the featured image.</p>";
    }
}
?>
<!-- <div class="container"> -->
    <div class="dashboard-user">
        <aside class="dashboard-sidebar">
        </aside>
        <div class="dashboard-post-publication-form">
            <h2>Welcome, <?php echo esc_html($current_user->display_name); ?>! This is you personal Dashboard.</h2>
            <h6>Add New Post</h6>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="post_title" placeholder="Post Title" required>
                <textarea name="post_content" placeholder="Post Content" required></textarea>
                <label for="post_thumbnail" class="custom-image-upload">Add Featured Image</label>
                <input type="file" name="post_thumbnail" id="post_thumbnail" accept="image/*" style="display:none;" required>
                <p id="image-upload-status" class="upload-status"></p>
                <button type="submit" name="submit_post" class="user-dashboard-form-submit">Submit Post</button>
            </form>
        </div>
    </div>
<!-- </div> -->
<?php
get_footer();
?>
