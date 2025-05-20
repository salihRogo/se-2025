var AdminManageReservations = {
    fetch_shop_reservations(shop_id) {
        window.location.hash = "#admin-manage-reservations";
        RestClient.get(`admin/shop/reservations/${shop_id}`, function(reservations) {
            const reservationsContainer = document.getElementById("admin-reservations-container");
            reservationsContainer.innerHTML = "";

            reservations.forEach((reservation) => {
                const reservationDiv = document.createElement("div");
                reservationDiv.className = "single-user-item";
                reservationDiv.innerHTML = `
                    <table class="user-profile-table">
                        <tr>
                            <th class="label-cell">User Full Name</th>
                            <td class="value-cell editable" data-field="name">
                                <span class="display-mode">${reservation.full_name}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="label-cell">Reservation Time</th>
                            <td class="value-cell editable" data-field="reservation_time">
                                <span class="display-mode">${reservation.reservation_time}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="label-cell">Number of Guests</th>
                            <td class="value-cell editable" data-field="guests">
                                <span class="display-mode">${reservation.number_of_guests}</span>
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
                                    <button class="btn edit-btn" onclick="AdminManageReservations.approveReservation(${reservation.id})">
                                        <i class="fas fa-trash-alt"></i> Approve
                                    </button>
                                    <button class="btn delete-btn" onclick="AdminManageReservations.denyReservation(${reservation.id})">
                                        <i class="fas fa-trash-alt"></i> Deny
                                    </button>
                                    <button class="btn view-btn" onclick="AdminManageReservations.deleteReservation(${reservation.id})">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br>
                `;
                reservationsContainer.appendChild(reservationDiv);
            });
        });
    }
}