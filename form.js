const cities = [
  "Dhaka",
  "New York",
  "London",
  "Tokyo",
  "Paris",
  "Toronto",
  "Sydney",
  "Dubai",
  "Singapore",
  "Istanbul"
];

const citySelect = document.getElementById("pcities");

cities.forEach(function(city) {
  const option = document.createElement("option");
  option.value = city;
  option.textContent = city;
  citySelect.appendChild(option);

});


const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');
const locationInput = document.getElementById('location');
const zip = document.getElementById('zipcode');
const interestsSelect = document.getElementById('pcities');
const checkbox = document.getElementById('agree');

const setError = (element, message) => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector('.error');

  errorDisplay.innerText = message;
  inputControl.classList.add('error');
  inputControl.classList.remove('success')
}

const setSuccess = element => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector('.error');

  errorDisplay.innerText = '';
  inputControl.classList.add('success');
  inputControl.classList.remove('error');
};

const isValidEmail = email => {
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}
const isValidUsername = username => {
  const re = /^[a-zA-Z]{2,}(?: [a-zA-Z]{2,})+$/;
  return re.test(String(username).toLowerCase());
}
const validateLocation = () => {
  const locationValue = locationInput.value.trim();
  if (locationValue === '') {
      setError(locationInput, 'Location is required');
      return false;
  } else {
      setSuccess(locationInput);
      return true;
  }
};


function validateInputs (){
  const usernameValue = username.value.trim();
  const emailValue = email.value.trim();
  const passwordValue = password.value.trim();
  const password2Value = password2.value.trim();
  const selectedOptions = [...interestsSelect.selectedOptions];


  var isValid = true;

  if (usernameValue === '') {
      setError(username, 'Full name is required');
      isValid = false;
  } else if (!isValidUsername(usernameValue)) {
      setError(username, 'Provide a valid Full name');
      isValid = false;
  } else {
      setSuccess(username);
  }

  if (emailValue === '') {
      setError(email, 'Email is required');
      isValid = false;
  } else if (!isValidEmail(emailValue)) {
      setError(email, 'Provide a valid email address');
      isValid = false;
  } else {
      setSuccess(email);
  }

  if (passwordValue === '') {
      setError(password, 'Password is required');
      isValid = false;
  } else if (passwordValue.length < 8) {
      setError(password, 'Password must be at least 8 characters.');
      isValid = false;
  } else {
      setSuccess(password);
  }

  if (password2Value === '') {
      setError(password2, 'Please confirm your password');
      isValid = false;
  } else if (password2Value !== passwordValue) {
      setError(password2, "Passwords don't match");
      isValid = false;
  } else {
      setSuccess(password2);
  }

  // if (!checkbox.checked) {
  //     isValid = false;
  // }
  // else{
  //     setSuccess(checkbox);
  // }

  const selectedCities = [...pcities.options].filter(option => option.selected);
    if (selectedCities.length == 0) {
      setError(interestsSelect, " Please select at least one city");
      isValid = false;
    }
    else{
      setSuccess(interestsSelect);
    }

  if (isValid) {
      alert("Form submitted successfully!");
      showColor();
      console.log("Success");
      const selectedCities = [...document.getElementById("pcities").selectedOptions].map(opt => opt.value);
      showAQI(selectedCities);
      console.log(selectedCities);
  }
  
  return isValid;
  //showAQI();
};

