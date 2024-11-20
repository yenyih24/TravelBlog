// Select individual form elements by their IDs and assign them to variables for easier access
var validate;
document.addEventListener("DOMContentLoaded", () => {
  // 確保 DOM 元素已加載完成後再執行
  console.log("DOM fully loaded and parsed.");

  // 你的表單驗證代碼
  let emailInput = document.querySelector("#email");
  let loginInput = document.querySelector("#username");
  let passInput = document.querySelector("#password");
  let pass2Input = document.querySelector("#confirm_password");
  let newsletter = document.querySelector("#newsletter");
  let termInput = document.querySelector("#terms");

  // 檢查表單元素是否存在，避免執行後續操作時出錯
  if (!emailInput || !loginInput || !passInput || !pass2Input || !termInput) {
    console.error("Form elements not found. Check the DOM structure.");
    return;
  }

  // create paragraph to display the error Msg returned by validateEmail() function
  // and assign this paragraph to the class warning to style the error Msg
  let emailError = document.createElement("p");
  emailError.setAttribute("class", "warning");
  //append the created element to the parent of email div
  document.querySelectorAll(".textfield")[0].append(emailError);

  // create paragraph to display the error Msg returned by validateLogin() function
  // and assign this paragraph to the class warning to style the error Msg
  let loginError = document.createElement("p");
  loginError.setAttribute("class", "warning");
  //append the created element to the parent of login div
  document.querySelectorAll(".textfield")[1].append(loginError);

  // create paragraph to display the error Msg returned by validatePass() function
  // and assign this paragraph to the class warning to style the error Msg
  let passError = document.createElement("p");
  passError.setAttribute("class", "warning");
  //append the created element to the parent of password div
  document.querySelectorAll(".textfield")[2].append(passError);

  // create paragraph to display the error Msg returned by validatePass2() function
  // and assign this paragraph to the class warning to style the error Msg
  let pass2Error = document.createElement("p");
  pass2Error.setAttribute("class", "warning");
  //append the created element to the parent of second password div
  document.querySelectorAll(".textfield")[3].append(pass2Error);

  // create paragraph to display the alert Msg returned by newsletter.addEventListener
  // and assign this paragraph to the class warning to style the alert Msg
  let newsletterAlert = document.createElement("p");
  newsletterAlert.setAttribute("class", "info");
  //append the created element to the parent of newsletter div
  document.querySelectorAll(".checkbox")[0].append(newsletterAlert);

  // create paragraph to display the error Msg returned by validateTerms() function
  // and assign this paragraph to the class warning to style the error Msg
  let termError = document.createElement("p");
  termError.setAttribute("class", "warning");
  //append the created element to the parent of check div
  document.querySelectorAll(".checkbox")[1].append(termError);

  //define a global variables
  let emailErrorMsg =
    "Email address should be non-empty with the format xyx@xyz.xyz.";
  let loginErrorMsg =
    "User name should be non-empty, and within 30 characters long.";
  let passErrorMsg =
    "Password should be at least 8 characters: 1 uppercase, 1 lowercase.";
  let pass2ErrorMsg = "Please retype password.";
  let termsErrorMsg = "Please accept the terms and conditions.";
  let defaultMsg = "";

  //method to validate email
  function validateEmail() {
    let email = emailInput.value; // access the value of the email
    let regexp = /\S+@\S+\.\S+/; //Regular expression pattern to validate email format (non-whitespace characters followed by '@', domain, and '.')

    if (regexp.test(email)) {
      //test is predefined method to check if the entered email matches the regexp
      error = defaultMsg;
    } else {
      error = emailErrorMsg;
    }
    return error;
  }

  // Method to validate the login input; checks if the login consists of 1 to 30 alphabetic characters
  function validateLogin() {
    let login = loginInput.value;
    let regexp = /^[a-zA-Z]{1,30}$/; // Regular expression to validate the login input

    if (regexp.test(login)) {
      loginInput.value = login.toLowerCase(); // Convert the login to lowercase if valid
      message = defaultMsg;
    } else {
      message = loginErrorMsg;
    }
    return message;
  }

  //method to validate password input; check if password contain at least one uppercase letter, one lowercase letter, and more than 8 character long
  function validatePass() {
    let password = passInput.value;
    let regexp = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/; //Regular expression to validate the password input

    if (regexp.test(password)) {
      message = defaultMsg;
    } else {
      message = passErrorMsg;
    }
    return message;
  }

  //method to validate second password
  function validatePass2() {
    let password = passInput.value;
    let password2 = pass2Input.value;
    // show error massage when the password is empty, second password is empty, and second password not match first password.
    if (password === "" || password2 === "" || password !== password2) {
      message = pass2ErrorMsg;
      return message;
    }
    return defaultMsg;
  }

  //method to validate the terms
  function validateTerms() {
    if (termInput.checked) return defaultMsg;
    else return termsErrorMsg;
  }

  //event handler for submit event
  validate = function validate() {
    console.trace("Form validation started");
    console.trace();
    let valid = true; //global validation

    let emailValidation = validateEmail();
    if (emailValidation !== defaultMsg) {
      emailError.textContent = emailValidation;
      valid = false;
    }

    let loginValidation = validateLogin();
    if (loginValidation !== defaultMsg) {
      loginError.textContent = loginValidation;
      valid = false;
    }

    let passValidation = validatePass();
    if (passValidation !== defaultMsg) {
      passError.textContent = passValidation;
      valid = false;
    }

    let pass2Validation = validatePass2();
    if (pass2Validation !== defaultMsg) {
      pass2Error.textContent = pass2Validation;
      valid = false;
    }

    let termsValidation = validateTerms();
    if (termsValidation !== defaultMsg) {
      termError.textContent = termsValidation;
      valid = false;
    }
    return valid;
  }

  // event listener to empty the text inside the paragraphs when reset
  function resetFormError() {
    emailError.textContent = defaultMsg;
    loginError.textContent = defaultMsg;
    passError.textContent = defaultMsg;
    pass2Error.textContent = defaultMsg;
    newsletterAlert.textContent = defaultMsg;
    termError.textContent = defaultMsg;
  }
  document.registration.addEventListener("reset", resetFormError);

  // // add event listener to the email if you entered correct email,the error paragraph with be empty

  emailInput.addEventListener("blur", () => {
    // arrow function
    let x = validateEmail();
    if (x == defaultMsg) {
      emailError.textContent = defaultMsg;
    }
  });

  //add event listener to the login if you entered correct name, the error paragraph will be empty.
  loginInput.addEventListener("blur", () => {
    // arrow function
    let x = validateLogin();
    if (x == defaultMsg) {
      loginError.textContent = defaultMsg;
    }
  });

  // add event listener to the password, if you entered the correct format of the password, the error paragraph will be empty.
  passInput.addEventListener("blur", () => {
    // arrow function
    let x = validatePass();
    if (x == defaultMsg) {
      passError.textContent = defaultMsg;
    }
  });
  // add event listener to the second password, if you entered the correct format of the second password, the error paragraph will be empty.
  pass2Input.addEventListener("blur", () => {
    // arrow function
    let x = validatePass2();
    if (x == defaultMsg) {
      pass2Error.textContent = defaultMsg;
    } else {
      pass2Error.textContent = pass2ErrorMsg;
    }
  });

  // add event listener to the newsletter checkbox, to pop out the warning message when user click the check box.
  newsletter.addEventListener("change", function () {
    if (this.checked) {
      alert("You may receive spam emails if you subscribe to the newsletter.");
    }
  });

  // // add event listener to the checkbox if you check the terms box,the error paragraph with be empty
  termInput.addEventListener("change", function () {
    // anonymous function
    if (this.checked) {
      termError.textContent = defaultMsg;
    }
  });
});
