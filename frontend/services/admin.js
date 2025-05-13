var Admin = {
  fetch_all_users() {
    RestClient.get("admin/users", function (data) {
      const usersContainer = document.getElementById("admin-users-container");
      usersContainer.innerHTML = "";

      // Sort users: Admins first, then others
      data.sort((a, b) => {
        if (a.role === "admin" && b.role !== "admin") return -1; // Admin comes first
        if (a.role !== "admin" && b.role === "admin") return 1;  // Non-admin comes later
        return 0; // Keep the same order for users with the same role
      });

      // Render sorted users
      data.forEach((user) => {
        const userDiv = document.createElement("div");
        userDiv.className = "single-user-item";
        userDiv.innerHTML = `
        <table class="user-profile-table">
          <tr>
            <th class="label-cell">Full Name</th>
            <td class="value-cell editable" data-field="full_name">
              <span class="display-mode">${user.full_name}</span>
              <input type="text" class="edit-mode form-control" value="${
                user.full_name
              }" style="display:none;">
              <div class="invalid-feedback">Please provide a valid name</div>
            </td>
          </tr>
          <tr>
            <th class="label-cell">Email</th>
            <td class="value-cell editable" data-field="email">
              <span class="display-mode">
                <a href="mailto:${user.email}" class="email-link">${
          user.email
        }</a>
              </span>
              <input type="email" class="edit-mode form-control" value="${
                user.email
              }" style="display:none;">
              <div class="invalid-feedback">Please provide a valid email</div>
            </td>
          </tr>
          <tr>
            <th class="label-cell">Phone Number</th>
            <td class="value-cell editable" data-field="phone_number">
              <span class="display-mode">${
                user.phone_number || "<span class='na-badge'>N/A</span>"
              }</span>
              <input type="tel" class="edit-mode form-control" value="${
                user.phone_number || ""
              }" style="display:none;">
            </td>
          </tr>
          <tr>
            <th class="label-cell">Role</th>
            <td class="value-cell editable" data-field="role">
              <span class="display-mode">
                <span class="role-badge ${user.role.toLowerCase()}">${
          user.role
        }</span>
              </span>
              <select class="edit-mode form-select" style="display:none;">
                <option value="admin" ${
                  user.role === "admin" ? "selected" : ""
                }>Admin</option>
                <option value="user" ${
                  user.role === "user" ? "selected" : ""
                }>User</option>
              </select>
            </td>
          </tr>
          <tr class="actions-row">
            <td colspan="2">
              <div class="action-buttons">
                <button id="edit-button" class="btn edit-btn" onclick="openEditModal('${user.id}')">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <button id="delete-button" class="btn delete-btn" onclick="deleteUser('${
                  user.id
                }')">
                  <i class="fas fa-trash-alt"></i> Delete
                </button>
              </div>
            </td>
          </tr>
        </table>
            `;
        usersContainer.appendChild(userDiv);
      });
    });
  },
};

function openEditModal(user_id) {
  // Fetch the user data asynchronously
  RestClient.get("user/" + user_id, function (data) {
    const user = data; // Assign the user data here

    // Populate the modal fields with user data
    document.getElementById("editFullName").value = user.full_name;
    document.getElementById("editPhoneNumber").value = user.phone_number || "";
    document.getElementById("editRole").value = user.role;
    document.getElementById("editPassword").value = ""; // Leave password empty

    // Store the user ID in a hidden field or variable for later use
    document.getElementById("userModal").dataset.userId = user.id;

    // Show the modal
    $("#userModal").modal("show");
  });
}

function deleteUser(user_id) {
  // Confirm deletion with the user
  if (confirm("Are you sure you want to delete this user?")) {
    // Send DELETE request to the backend
    RestClient.delete(`admin/users/${user_id}`, user_id, function (response) {
      // Notify the user of successful deletion
      toastr.success("User deleted successfully!");

      // Refresh the user table
      Admin.fetch_all_users();
    }, function (error) {
      // Handle errors
      toastr.error("Failed to delete the user. Please try again.");
    });
  }
}