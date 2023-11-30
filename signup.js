function toggleForm() {
    var loginForm = document.getElementById('login-form');
    var signupForm = document.getElementById('signup-form');

    if (loginForm.style.display === 'none') {
      loginForm.style.display = 'block';
      signupForm.style.display = 'none';
      document.querySelector('.auth-header h2').innerText = 'Login';
    } else {
      loginForm.style.display = 'none';
      signupForm.style.display = 'block';
      document.querySelector('.auth-header h2').innerText = 'Sign Up';
    }
  }