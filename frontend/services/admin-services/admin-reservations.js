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

        reservations.forEach((reservation) => {
          const reservationDiv = document.createElement("div");
          reservationDiv.className = "single-user-item";
          reservationDiv.innerHTML = `
                    <table class="user-profile-table">
                        <tr>
                            <th class="label-cell">Customer Name</th>
                            <td class="value-cell editable" data-field="name">
                                <span class="display-mode">${
                                  reservation.full_name
                                }</span>
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
                                <span class="status-badge ${reservation.status.toLowerCase()}">${
            reservation.status
          }</span>
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
  deleteReservation(reservation_id) {
    alert("Are you sure that you want to delete this reservation?");
    RestClient.get("reservations/" + reservation_id, function (reservation) {
      if (reservation.status === "Cancelled") {
        RestClient.delete(
          `reservations/${reservation.id}`,
          reservation.id,
          function () {
            AdminManageReservations.fetch_shop_reservations(reservation.shop_id);
          }
        );
      }
    });
  },
  approveReservation(reservation_id) {
    alert("Are you sure that you want to approve this reservation?");
    RestClient.get("reservations/" + reservation_id, function (reservation) {
      if (reservation.status === "Pending") {
        reservation.status = "Confirmed";
        RestClient.patch(
          `admin/reservation/status/${reservation.id}`,
          reservation,
          function () {
            increaseUsersLoyaltyPoints(
              reservation.user_id,
              reservation.shop_id
            );
            checkUsersLoyaltyPoints(reservation.user_id);
          }
        );
      }
    });
  },
  denyReservation(reservation_id) {
    alert("Are you sure that you want to deny this reservation?");
    RestClient.get("reservations/" + reservation_id, function (reservation) {
      if (reservation.status === "Pending") {
        reservation.status = "Cancelled";
        RestClient.patch(
          `admin/reservation/status/${reservation.id}`,
          reservation,
          function () {}
        );
      }
    });
  },
};

increaseUsersLoyaltyPoints = function (user_id, shop_id) {
  RestClient.get(`user/${user_id}`, function (user) {
    user.loyalty_points = user.loyalty_points + 1;
    RestClient.put(`user/${user.id}`, user, function () {
      AdminManageReservations.fetch_shop_reservations(shop_id);
    });
  });
};

checkUsersLoyaltyPoints = function (user_id) {
  RestClient.get(`users/${user_id}`, function (user) {
    if (user.loyalty_points === 10) {
      RestClient.post("coupons/user", user.id, function () {
        user.loyalty_points = 0;
        RestClient.put(`user/${user.id}`, user, function () {});
      });
    }
  });
};
