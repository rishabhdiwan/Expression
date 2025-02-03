    <!-- Footer -->
    <footer>
        <!-- The overlay background -->
        <div id="popupOverlay" class="popup-overlay"></div>
        <!-- Login Form Popup -->
        <div id="loginPopup" class="popup-form">
            <button type="button" class="close-btn" onclick="toggleForm('login')">&times;</button>
            <form id="loginForm" method="post" action="<?php echo esc_url( home_url('/login-submit') ); ?>">
                <input type="text" id="username" name="log" placeholder="Enter your Username" required>
                <input type="password" id="password" name="pwd" placeholder="Enter your Password" required>
                <input type="submit" value="Login">
                <p>Don't have an account? <a href="#" onclick="toggleForm('register')">Register here</a></p>
            </form>
        </div>
        <!-- Register Form Popup -->
        <div id="registerPopup" class="popup-form">
            <button type="button" class="close-btn" onclick="toggleForm('register')">&times;</button>
            <form id="registerForm" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                <input type="text" name="name" id="name" placeholder="Enter your Name" required>
                <input type="email" id="email" name="user_email" placeholder="Enter your Email" required>
                <input type="text" id="phone" name="user_phone" placeholder="Enter your Phone Number" required>
                <input type="text" id="username" name="user_login" placeholder="Choose a Username" required>
                <input type="password" name="password" id="password" placeholder="Enter your Password" required>
                <input type="submit" value="Register">
            </form>
        </div>
        <?php if ( isset($_GET['registration']) && $_GET['registration'] == 'success' ) : ?>
            <input type="hidden" id="registrationStatus" value="success">
            <div id="registrationPopup" class="popup">
                <p>Registration Successful! 🎉</p>
                <button onclick="closePopup()">OK</button>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("registrationPopup").style.display = "block";
                });

                function closePopup() {
                    document.getElementById("registrationPopup").style.display = "none";
                    window.history.pushState({}, document.title, window.location.pathname); // Remove query param
                }
            </script>
        <?php endif; ?>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>