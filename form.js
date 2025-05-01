const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');
const locationInput = document.getElementById('location');
const zip = document.getElementById('zipcode');
const interestsSelect = document.getElementById('pcities');
const checkbox = document.getElementById('agree');

form.addEventListener('submit', e => {
    e.preventDefault();
    validateInputs();
        
});

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

const validateZipcode = () => {
    const zipValue = zip.value.trim();
    if (!/^\d{4,10}$/.test(zipValue)) {
        setError(zip, 'Zipcode must be 4–10 digits');
        return false;
    } else {
        setSuccess(zip);
        return true;
    }
};

const validateSelectedCities = () => {
    const selectedOptions = [...interestsSelect.selectedOptions];
    if (selectedOptions.length === 0) {
        setError(interestsSelect, 'Please select at least one City');
        return false;
    } else {
        setSuccess(interestsSelect);
        return true;
    }
};


const validateInputs = () => {
    const usernameValue = username.value.trim();
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const password2Value = password2.value.trim();


    let isValid = true;

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


    if (!validateLocation()) isValid = false;
    if (!validateZipcode()) isValid = false;
    if (!validateSelectedCities()) isValid = false;

//     if (locationInput.value.trim() === '') {
//         setError(locationInput, 'Location is required');
//         isValid = false;
//     } else {
//         setSuccess(locationInput);
//     }
    
//     // const zip = zipcodeInput.value.trim();
//     if (zip === '') {
//         setError(zipcodeInput, 'Zipcode is required');
//         isValid = false;
//     // } else if (!/^\d{4,10}$/.test(zip)) {
//     //     setError(zipcodeInput, 'Zipcode must be 4–10 digits');
//     //     isValid = false;
//     } else {
//         setSuccess(zipcodeInput);
//     }

//     const selectedOptions = [...interestsSelect.selectedOptions];
//     if (selectedOptions.length === 0) {
//         setError(interestsSelect, 'Please select at least one City');
//         isValid = false;
//     } else {
//         setSuccess(interestsSelect);
// }

    if (!checkbox.checked) {
        isValid = false;
    }

    if (isValid) {
        alert("Form submitted successfully!");
        // form.submit();
        form.reset();
    }
};