function register_user() {
  FormValidation.validate(
    "register-form",
    {
      full_name: {
        required: true,
        minlength: 3,
      },
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 8,
      },
      password_confirm: {
        required: true,
        minlength: 8,
      },
      phone_number: {
        required: true,
        minlength: 8,
      },
    },
    function (data) {
      Utils.block_ui("register-button");
      RestClient.post("register", data, function (response) {
        Utils.unblock_ui("register-button");
        toastr.success("User registered succesfully");
        document.getElementById("register-form").reset();
        window.location.hash = "#login";
      }, function(error) {
        toastr.error(error.error);
      });
    }
  );
}

function login_user() {
  FormValidation.validate("login-form", {}, function (data) {
    Utils.block_ui("login-button");

    RestClient.post(
      "login",
      data,
      function (response) {
        window.localStorage.setItem("token", response.token);
        window.localStorage.setItem("user_id", response.id);
        window.localStorage.setItem("role", response.role);

        Utils.unblock_ui("login-button");
        toastr.success("You logged in successfully");
        window.location.hash = "#home";

        check_user_presence();

        if (response.role === "admin") {
          window.location.hash = "#admin-dashboard";
          window.location.reload();
        } else {
          window.location.hash = "#home";
          window.location.reload();
        }
      },
      function (error) {
        toastr.error("Error occurred while logging into your account");
      }
    );
  });
}

function display_user_profile(user_id) {
  RestClient.get("user/" + user_id, function (data) {
    const user = data;
    const profileContainer = document.getElementById("profile-container");
    profileContainer.innerHTML = `
      <div class="profile-details">
        <h2>${user.full_name}</h2>
        <p><strong>Email:</strong> ${user.email}</p>
        <p><strong>Phone Number:</strong> ${user.phone_number}</p>
      </div>
    `;
  });
}

function display_all_users() {
  RestClient.get("users", function (data) {
    const usersContainer = document.getElementById("users-container");
    usersContainer.innerHTML = "";

    data.forEach((user) => {
      const userDiv = document.createElement("div");
      userDiv.className = "single-user-item";
      userDiv.innerHTML = `
        <div class="user-details">
          <h3>${user.full_name}</h3>
          <p><strong>Email:</strong> ${user.email}</p>
          <p><strong>Phone:</strong> ${user.phone_number}</p>
        </div>
      `;
      usersContainer.appendChild(userDiv);
    });
  });
}

window.addEventListener("hashchange", function () {
  handle_hash_change();
});

function handle_hash_change() {
  const currentHash = window.location.hash;

  if (currentHash === "#login") {
    load_login_page();
  } else if (currentHash === "#register") {
    load_register_page();
  } else if (currentHash === "#profile") {
    load_user_profile();
  } else {
    console.log("Unhandled hash:", currentHash);
  }
}

function load_user_profile() {
  const user_id = window.localStorage.getItem("user_id");

  if (!user_id) {
    window.location.hash = "#login";
    return;
  }

  RestClient.get("user/" + user_id, function (data) {
    document.getElementById("profile-full-name").textContent =
      data.full_name || "Full Name";
    document.getElementById("profile-email").textContent =
      "Email: " + data.email || "Email";
    document.getElementById("profile-phone-number").textContent =
      "Phone: " + data.phone_number || "Phone Number";

    const firstName = data.full_name.split(" ")[0];

    const greetingElement = document.querySelector(".section-header h2");
    if (greetingElement) {
      greetingElement.textContent = `Hi ${firstName}, welcome to your profile`;
    }
  });
  loadUserReservations();
  loadUserFavourites();
}

function logout_user() {
  window.localStorage.removeItem("user_id");
  window.localStorage.removeItem("token");
  window.localStorage.removeItem("role");

  const profileFullName = document.getElementById("profile-full-name");
  const profileEmail = document.getElementById("profile-email");
  const profilePhoneNumber = document.getElementById("profile-phone-number");

  if (profileFullName) profileFullName.textContent = "";
  if (profileEmail) profileEmail.textContent = "";
  if (profilePhoneNumber) profilePhoneNumber.textContent = "";

  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.reset();
  }

  const profileForm = document.getElementById("profile-form");
  if (profileForm) {
    profileForm.reset();
  }

  const greetingElement = document.querySelector(".section-header h2");
  if (greetingElement) {
    greetingElement.remove();
  }

  check_user_presence();

  window.location.hash = "#home";
  window.location.reload();
  toastr.success("You have been logged out successfully");
}

function check_user_presence() {
  const userId = window.localStorage.getItem("user_id");
  const userRole = window.localStorage.getItem("role");

  // Get the profile button element
  const profileButton = document.querySelector("#profile-button");

  if (userId) {
    // If user is logged in, redirect to the profile page
    if (profileButton) {
      if (userRole === "user") {
        profileButton.setAttribute("href", "#profile");
      } else if (userRole === "admin") {
        profileButton.setAttribute("href", "#admin-profile");
      }
    }
  } else {
    // If user is not logged in, redirect to the login page
    if (profileButton) {
      profileButton.setAttribute("href", "#login");
      profileButton.innerHTML = '<i class="fas fa-user"></i> ';
    }
  }
}

window.addEventListener("hashchange", function () {
  if (window.location.hash === "#login") {
    load_login_page();
  }
});
if (window.location.hash === "#login") {
  load_login_page();
}
function load_login_page() {
  console.log("Navigating to the login page...");
}

window.addEventListener("hashchange", function () {
  if (window.location.hash === "#register") {
    load_register_page();
  }
});
// lkaallalaala
if (window.location.hash === "#register") {
  load_register_page();
}
function load_register_page() {
  console.log("Navigating to the signup page...");
}

function showResetPasswordModal() {
  document.getElementById("resetPasswordModal").classList.add("show");
  clearResetPasswordErrors();
}
function closeResetPasswordModal() {
  document.getElementById("resetPasswordModal").classList.remove("show");
}

// Clear error messages in the modal
function clearResetPasswordErrors() {
  ["new-password", "confirm-password", "general"].forEach(function (field) {
    const el = document.getElementById("error-reset-" + field);
    if (el) el.textContent = "";
  });
}

function resetPassword() {
  clearResetPasswordErrors();
  const newPass = document.getElementById("reset-new-password").value;
  const confirmPass = document.getElementById("reset-confirm-password").value;
  let hasError = false;

  if (!newPass || newPass.length < 8) {
    document.getElementById("error-reset-new-password").textContent =
      "New password must be at least 8 characters.";
    hasError = true;
  }
  if (newPass !== confirmPass) {
    document.getElementById("error-reset-confirm-password").textContent =
      "Passwords do not match.";
    hasError = true;
  }
  if (hasError) return;
  const userId = localStorage.getItem("user_id");
  RestClient.put(
    `user/${userId}/password`,
    {
      new_password: newPass,
    },
    function (response) {
      closeResetPasswordModal();
      toastr.success("Password changed successfully!");
    },
    function (error) {
      if (error && error.message) {
        if (error.message.includes("New password")) {
          document.getElementById("error-reset-new-password").textContent =
            error.message;
        } else {
          document.getElementById("error-reset-general").textContent =
            error.message;
        }
      } else {
        document.getElementById("error-reset-general").textContent =
          "Error resetting password.";
      }
    }
  );
}
