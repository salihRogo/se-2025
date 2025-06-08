var AdminManageShops = {
  fetch_all_shops() {
    RestClient.get("admin/shops", function (data) {
      const shopsContainer = document.getElementById("admin-shops-container");
      shopsContainer.innerHTML = "";

      data.forEach((shop) => {
        const shopDiv = document.createElement("div");
        shopDiv.className = "single-user-item";
        shopDiv.innerHTML = `
        <table class="user-profile-table">
          <tr>
            <th class="label-cell">Shop Name</th>
            <td class="value-cell editable" data-field="name">
              <span class="display-mode">${shop.name}</span>
            </td>
          </tr>
          <tr>
            <th class="label-cell">Address</th>
            <td class="value-cell editable" data-field="address">
              <span class="display-mode">${shop.address}</span>
            </td>
          </tr>
          <tr>
            <th class="label-cell">City</th>
            <td class="value-cell editable" data-field="city">
              <span class="display-mode">${shop.city}</span>
            </td>
          </tr>
          <tr>
            <th class="label-cell">Contact Number</th>
            <td class="value-cell editable" data-field="contact_number">
              <span class="display-mode">${shop.contact_number}</span>
            </td>
          </tr>
          <tr>
            <th class="label-cell">Working Hours</th>
            <td class="value-cell editable" data-field="opens_at">
              <span class="display-mode">${shop.opens_at} - ${shop.closes_at}</span>
            </td>
          </tr>
          <tr>
            <th class="label-cell">Description</th>
            <td class="value-cell editable" data-field="description">
              <span class="display-mode">${shop.description}</span>
            </td>
          </tr>
          <tr class="actions-row">
            <td colspan="2">
              <div class="action-buttons">
                <button class="btn view-btn" onclick="AdminManageReservations.fetch_shop_reservations('${shop.id}')">
                  <i class="fas fa-ticket"></i> View Reservations
                </button>
                <button class="btn view-btn" onclick="AdminManageReviews.displayShopReviews('${shop.id}')">
                  <i class="fas fa-comments"></i> View Reviews
                </button>
                <button class="btn edit-btn" onclick="openShopEditModal('${shop.id}')">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn delete-btn" onclick="deleteShop('${shop.id}')">
                  <i class="fas fa-trash-alt"></i> Delete
                </button>
              </div>
            </td>
          </tr>
        </table>
        <br>
        `;
        shopsContainer.appendChild(shopDiv);
      });
    });
  },
};

function openShopEditModal(shop_id) {
  // Fetch the shop data asynchronously
  RestClient.get("shops/" + shop_id, function (shop_unreal) {
    shop = shop_unreal[0];
    // Populate the modal fields with shop data
    document.getElementById("editShopName").value = shop.name || "";
    document.getElementById("editAddress").value = shop.address || "";
    document.getElementById("editCity").value = shop.city || "";
    document.getElementById("editContactNumber").value =
      shop.contact_number || "";
    document.getElementById("editOpensAt").value = shop.opens_at || "";
    document.getElementById("editClosesAt").value = shop.closes_at || "";
    document.getElementById("editDescription").value = shop.description || "";

    // Store the shop ID in a hidden field or variable for later use
    document.getElementById("shopModal").dataset.shopId = shop.id;

    // Show the modal
    $("#shopModal").modal("show");
  });
}

function deleteShop(shop_id) {
  if (confirm("Are you sure you want to delete this shop?")) {
    RestClient.delete(
      `admin/shops/${shop_id}`,
      shop_id,
      function (response) {
        toastr.success("Shop deleted successfully!");
        AdminManageShops.fetch_all_shops();
      },
      function (error) {
        toastr.error("Failed to delete the shop. Please try again.");
      }
    );
  }
}

function submitAddShop() {
  // Gather form values
  const shopData = {
    name: document.getElementById("addShopName").value,
    address: document.getElementById("addAddress").value,
    city: document.getElementById("addCity").value,
    contact_number: document.getElementById("addContactNumber").value,
    opens_at: document.getElementById("addOpensAt").value,
    closes_at: document.getElementById("addClosesAt").value,
    description: document.getElementById("addDescription").value,
  };

  // Handle image upload
  const imageInput = document.getElementById("addShopImage");
  const imageFile = imageInput.files[0];

  if (!imageFile) {
    toastr.error("Please select an image file for the shop.");
    return;
  }

  const formData = new FormData();
  formData.append("shopImage", imageFile);

  // 1. Upload the image
  fetch("/se-2025/backend/api/upload/shop-image/", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) throw new Error("Failed to upload image");
      return response.json();
    })
    .then((fileData) => {
      shopData.image_url = "assets/img/" + fileData.filename;
      // 2. Add the shop (without image, get shop ID)
      RestClient.post("admin/shops", shopData, function (shopResponse) {
        // 3. Link the image to the shop
        const shopId = shopResponse.id || shopResponse.shop_id;
        if (!shopId) {
          toastr.error("Shop created, but could not link image.");
          return;
        }
        $("#addShopModal").modal("hide");
        toastr.success("Shop added successfully!");
        AdminManageShops.fetch_all_shops();
        document.getElementById("addShopForm").reset();
      });
    })
    .catch((err) => {
      toastr.error("Failed to add shop: " + (err.message || "Unknown error"));
    });
}
