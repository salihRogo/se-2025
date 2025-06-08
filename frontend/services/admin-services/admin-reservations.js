var AdminManageReservations = {
  fetch_shop_reservations(shop_id) {
    window.location.hash = "#admin-manage-reservations";
    RestClient.get(
      `admin/shop/reservations/${shop_id}`,
      function (reservations) {
        const reservationsContainer = document.getElementById(
          "admin-reservations-container"
        );
        reservationsContainer.innerHTML = "";

        if (!reservations || reservations.length === 0) {
          reservationsContainer.innerHTML = `
            <div class="alert alert-info text-center my-4">
              There are currently no reservations for this shop.
            </div>
          `;
          return;
        }

        reservations.forEach((reservation) => {
          const reservationDiv = document.createElement("div");
          reservationDiv.className = "single-user-item";
          reservationDiv.innerHTML = `
            <table class="user-profile-table">
              <tr>
                <th class="label-cell">Customer Name</th>
                <td class="value-cell editable" data-field="name">
                  <span class="display-mode">${reservation.full_name}</span>
                </td>
              </tr>
              <tr>
                <th class="label-cell">Reservation Time</th>
                <td class="value-cell editable" data-field="reservation_time">
                  <span class="display-mode">${
                    reservation.reservation_time
                  }</span>
                </td>
              </tr>
              <tr>
                <th class="label-cell">Number of Guests</th>
                <td class="value-cell editable" data-field="guests">
                  <span class="display-mode">${
                    reservation.number_of_guests
                  }</span>
                </td>
              </tr>
              <tr>
                <th class="label-cell">Status</th>
                <td class="value-cell editable" data-field="role">
                  <span class="display-mode">
                    <span class="status-badge ${reservation.status.toLowerCase()}">
                      ${reservation.status}
                    </span>
                  </span>
                </td>
              </tr>
              <tr class="actions-row">
                <td colspan="2">
                  <div class="action-buttons">
                    <button class="btn edit-btn" onclick="AdminManageReservations.approveReservation(${
                      reservation.id
                    })">
                      <i class="fas fa-check"></i> Approve
                    </button>
                    <button class="btn delete-btn" onclick="AdminManageReservations.denyReservation(${
                      reservation.id
                    })">
                      <i class="fas fa-ban"></i> Deny
                    </button>
                    <button class="btn delete-btn" onclick="AdminManageReservations.deleteReservation(${
                      reservation.id
                    })">
                      <i class="fas fa-trash"></i> Delete
                    </button>
                  </div>
                </td>
              </tr>
            </table>
            <br>
          `;
          reservationsContainer.appendChild(reservationDiv);
        });
      }
    );
  },
};

increaseUsersLoyaltyPoints = function (user_id, shop_id) {
  RestClient.get(`user/${user_id}`, function (user) {
    user.loyalty_points = user.loyalty_points + 1;

    RestClient.put(`user/${user.id}`, user, function () {
      AdminManageReservations.fetch_shop_reservations(shop_id);
    });

    const data = {
      user_id: user_id,
    };

    if (user.loyalty_points === 10) {
      RestClient.post("coupons/user", data, function () {
        user.loyalty_points = 0;
        RestClient.put(`user/${user.id}`, user, function () {});
      });
    }
  });
};

checkUsersLoyaltyPoints = function (user_id) {
  RestClient.get(`user/${user_id}`, function (user) {
    if (user.loyalty_points === 10) {
      RestClient.post("coupons/user", user.id, function () {
        user.loyalty_points = 0;
        RestClient.put(`user/${user.id}`, user, function () {});
      });
    }
  });
};
