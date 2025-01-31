<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <title>Expression</title>
    <?php wp_head(); ?>
</head>
<body>
    <header>
        <div class="title-of-the-page">
            <div class="container">
                <div class="header-content">
                    <div>
                        <h2><a href = "<?php echo get_home_url(); ?>">Expression</a></h2>
                    </div>
                    <div class="buttons-for-login-and-signup">
                        <?php if (!is_user_logged_in()) : ?>
                            <!--Login and Register Buttons-->
                            <button id="loginButton">Login</button>
                            <button id="registerButton">Register</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>