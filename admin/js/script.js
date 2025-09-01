function togglePassword() {
  const passwordInput = document.getElementById("password1");
  const icon = document.querySelector(".toggle-password i");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    icon.classList.replace("fa-eye", "fa-eye-slash");
  } else {
    passwordInput.type = "password";
    icon.classList.replace("fa-eye-slash", "fa-eye");
  }
}

document.getElementById("darkToggleIcon").addEventListener("click", function () {
  document.body.classList.toggle("dark-mode");
  this.classList.toggle("fa-moon");
  this.classList.toggle("fa-sun");
});
