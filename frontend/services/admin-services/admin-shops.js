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
          <tr>
            <th class="label-cell">Image Url</th>
            <td class="value-cell editable" data-field="image_url">
              <span class="display-mode">
                <span class="display-mode">${shop.image_url}</span>
              </span>
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
