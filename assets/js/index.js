// Function to show or hide the forms
function toggleForm(formType) {
    var loginPopup = document.getElementById('loginPopup');
    var registerPopup = document.getElementById('registerPopup');
    var overlay = document.getElementById('popupOverlay');

    if (formType === 'login') {
        loginPopup.style.display = loginPopup.style.display === 'block' ? 'none' : 'block';
    } else if (formType === 'register') {
        registerPopup.style.display = registerPopup.style.display === 'block' ? 'none' : 'block';
    }

    // Display the overlay background when form is shown
    if (loginPopup.style.display === 'block' || registerPopup.style.display === 'block') {
        overlay.style.display = 'block';
    } else {
        overlay.style.display = 'none';
    }
}

// Triggering the popups
document.getElementById('loginButton').addEventListener('click', function() {
    toggleForm('login');
});
document.getElementById('writeBlogButton').addEventListener('click', function() {
    toggleForm('login');
});

document.getElementById('registerButton').addEventListener('click', function() {
    toggleForm('register');
});

// Close the popup if overlay is clicked
document.getElementById('popupOverlay').addEventListener('click', function() {
    if (document.getElementById('loginPopup').style.display === 'block') {
        toggleForm('login');
    } else if (document.getElementById('registerPopup').style.display === 'block') {
        toggleForm('register');
    }
});
