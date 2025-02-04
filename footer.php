    <!-- Footer -->
    <footer>
        <!-- The overlay background -->
        <div id="popupOverlay" class="popup-overlay"></div>
        <!-- Login Form Popup -->
        <div id="loginPopup" class="popup-form">
            <button type="button" class="close-btn" onclick="toggleForm('login')">&times;</button>
            <h2>Login and keep writing</h2>
            <form id="loginForm" method="post" action="<?php echo esc_url( home_url('/login-submit') ); ?>">
                <input type="text" id="username" name="log" placeholder="Enter your Username" required>
                <input type="password" id="password" name="pwd" placeholder="Enter your Password" required>
                <input type="submit" value="Login" class="login-register-forms">
                <p>Don't have an account? <a href="#" class = "register-link" onclick="toggleForm('register')">Register here</a></p>
            </form>
        </div>
        <!-- Register Form Popup -->
        <div id="registerPopup" class="popup-form">
            <button type="button" class="close-btn" onclick="toggleForm('register')">&times;</button>
            <h2>Register to publish your Blogs</h2>
            <form id="registerForm" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                <input type="text" name="firstname" id="firstname" placeholder="Enter your First Name" required>
                <input type="text" name="lastname" id="lastname" placeholder="Enter your Last Name" required>
                <input type="email" id="email" name="user_email" placeholder="Enter your Email" required>
                <input type="text" id="phone" name="user_phone" placeholder="Enter your Phone Number" required>
                <input type="text" id="username" name="user_login" placeholder="Enter a Username" required>
                <input type="password" name="password" id="password" placeholder="Enter your Password" required>
                <input type="submit" value="Register" class="login-register-forms">
            </form>
        </div>
        <?php if ( isset($_GET['registration']) && $_GET['registration'] == 'success' ) : ?>
            <input type="hidden" id="registrationStatus" value="success">
            <div id="registrationPopup" class="popup-notify">
                <p>Registration Successful!</p>
                <button onclick="closePopup()">OK</button>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("registrationPopup").style.display = "block";
                });
                function closePopup() {
                    document.getElementById("registrationPopup").style.display = "none";
                    window.history.pushState({}, document.title, window.location.pathname);
                }
            </script>
        <?php endif; ?>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>