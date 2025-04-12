const registrationForm = document.getElementById("registrationForm");
const errorMessages = document.getElementById("errorMessages");

registrationForm.addEventListener("submit", function (event) {
  event.preventDefault();

  const { fname, email, password } = registrationForm.elements;

  errorMessages.innerHTML = "";

  if (!fname.value.trim()) {
    displayError("Username is required.");
    return;
  }

  if (!email.value.trim() || !isValidEmail(email.value)) {
    displayError("Please enter a valid email address.");
    return;
  }

  if (!password.value.trim() || !isStrongPassword(password.value)) {
    displayError(
      "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character."
    );
    return;
  }

  alert("Registration successful!");
  registrationForm.reset();
});

function displayError(message) {
  errorMessages.innerHTML += `<div class="error">${message}</div>`;
}

function isValidEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function isStrongPassword(password) {
  return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/.test(password);
}