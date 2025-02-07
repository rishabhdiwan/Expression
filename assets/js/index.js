// Function to show or hide the forms
function toggleForm(formType) {
    var loginPopup = document.getElementById('loginPopup');
    var registerPopup = document.getElementById('registerPopup');
    var overlay = document.getElementById('popupOverlay');

    if (!loginPopup || !registerPopup || !overlay) return; 

    if (formType === 'login') {
        loginPopup.style.display = loginPopup.style.display === 'block' ? 'none' : 'block';
    } else if (formType === 'register') {
        registerPopup.style.display = registerPopup.style.display === 'block' ? 'none' : 'block';
    }
    overlay.style.display = (loginPopup.style.display === 'block' || registerPopup.style.display === 'block') ? 'block' : 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    // Attach event listeners to the forms, only if elements exist.
    let loginButton = document.getElementById("loginButton");
    let registerButton = document.getElementById("registerButton");
    let writeBlogButton = document.getElementById("writeBlogButton");
    if (loginButton) {
        loginButton.addEventListener("click", function() {
            toggleForm('login');
        });
    }
    if (writeBlogButton) {
        writeBlogButton.addEventListener("click", function() {
            toggleForm('login');
        });
    }
    if (registerButton) {
        registerButton.addEventListener("click", function() {
            toggleForm('register');
        });
    }
    // Close popup when overlay is clicked
    let popupOverlay = document.getElementById("popupOverlay");
    if (popupOverlay) {
        popupOverlay.addEventListener("click", function() {
            if (document.getElementById('loginPopup').style.display === 'block') {
                toggleForm('login');
            } else if (document.getElementById('registerPopup').style.display === 'block') {
                toggleForm('register');
            }
        });
    }
    // Upload Status for Image Upload
    let postThumbnailInput = document.getElementById("post_thumbnail");
    let statusElement = document.getElementById("image-upload-status");

    if (postThumbnailInput && statusElement) {
        postThumbnailInput.addEventListener("change", function () {
            let statusText = this.files.length > 0 ? "Image successfully uploaded." : "Image not uploaded";
            statusElement.textContent = statusText;
            statusElement.style.color = this.files.length > 0 ? 'yellowgreen' : 'red';
        });
    }
});
