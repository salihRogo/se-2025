function register_user() {
  FormValidation.validate("register-form", {}, function (data) {
    Utils.block_ui("register-button");
    //delete data.password_confirm;
    RestClient.post(
      "users",
      data,
      function (response) {
        Utils.block_ui("register-button");
        toastr.success("user registered succesfully");
        document.getElementById("register-form").reset();
        window.location.hash = "#login";
      },
      function (error) {
        toastr.error("error");
      }
    );
  });
}

function login_user() {
  FormValidation.validate("login-form", {}, function (data) {
    Utils.block_ui("login-button");
    console.log(data);
    RestClient.post(
      "login",
      data,
      function (response) {
        Utils.unblock_ui("login-button");
        toastr.success("You logged in successfully");
        window.location.hash = "#home";
      },
      function (error) {
        Utils.unblock_ui("login-button");
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
