function confirmReservation(shop_id) {
  const guestNumber = document.getElementById("number_of_guests").value;
  const reservationDate = document.getElementById("reservation-date").value;
  const reservationTime = document.getElementById("reservation-time").value;

  if (!guestNumber || !reservationDate || !reservationTime) {
    alert("Please fill out all fields.");
    return;
  }

  user_id = window.localStorage.getItem("user_id");

  data = {};
  data.shop_id = shop_id;
  data.user_id = user_id;
  data.number_of_guests = guestNumber;
  data.reservation_time = `${reservationDate} ${reservationTime}`;

  console.log(data);

  RestClient.post(
    "reservation",
    data,
    function (response) {
      window.setTimeout(1000);
      toastr.success(
        `Reservation confirmed for ${guestNumber} guests on ${reservationDate} at ${reservationTime}.`
      );
    },
    function () {
      toastr.warning(`You have to be logged in in order to reserve a spot.`);
    }
  );
}
function loadUserReservations() {
  const userId = window.localStorage.getItem("user_id");
  if (!userId) return;

  RestClient.get(
    `user/reservations/${userId}`,
    function (reservations) {
      const container = document.getElementById("reservations-list");
      container.innerHTML = "";

      if (reservations.length === 0) {
        container.innerHTML = `<p class="text-center w-100">You have no reservations yet. Make your first reservation and earn 1 loyalty point.</p>`;
        return;
      }

      reservations.forEach((reservation) => {
        let date = reservation.reservation_time;
        let time = "";
        if (date && date.includes(" ")) {
          [date, time] = reservation.reservation_time.split(" ");
        }

        let statusClass = "text-secondary";
        if (
          reservation.status === "Confirmed" ||
          reservation.status === "Approved"
        )
          statusClass = "text-success";
        else if (reservation.status === "Pending") statusClass = "text-warning";
        else if (reservation.status === "Cancelled")
          statusClass = "text-danger";

        container.innerHTML += `
          <div class="single-product-item reservation-card p-4 mb-4 w-100">
            <h4 class="mb-4 reservation-title text-center">${
              reservation.shop_name || "Shop"
            }</h4>
            <div class="reservation-details-row d-flex justify-content-between align-items-end flex-wrap mb-3">
              <div class="d-flex flex-column align-items-center">
                <span class="reservation-label"><strong>Date</strong></span>
                <span>${date || ""}</span>
              </div>
              <div class="d-flex flex-column align-items-center">
                <span class="reservation-label"><strong>Time</strong></span>
                <span>${time || ""}</span>
              </div>
              <div class="d-flex flex-column align-items-center">
                <span class="reservation-label"><strong>Guests</strong></span>
                <span>${reservation.number_of_guests}</span>
              </div>
              <div class="d-flex flex-column align-items-center">
                <span class="reservation-label"><strong>Status</strong></span>
                <span class="${statusClass}">${
          reservation.status || "Confirmed"
        }</span>
              </div>
              <div class="d-flex flex-column align-items-center">
                <button class="cart-btn mt-2" onclick="cancelReservation(${
                  reservation.id
                });">Cancel</button>
              </div>
            </div>
          </div>
        `;
      });
    },
    function () {
      toastr.error("Failed to load reservations.");
    }
  );
}

function cancelReservation(reservation_id) {
  RestClient.get(`reservations/${reservation_id}`, function (reservation) {
    if (reservation.status === "Pending") {
      RestClient.put(
        `reservations/${reservation.id}`,
        { status: "Cancelled" },
        function () {
          toastr.success("Reservation cancelled.");
          loadUserReservations();
        },
        function () {
          toastr.error("Failed to cancel reservation.");
        }
      );
    } else if (reservation.status === "Confirmed") {
      RestClient.put(
        `reservations/${reservation.id}`,
        { status: "Cancelled" },
        function () {
          toastr.success("Reservation cancelled.");
          decreaseUserLoyaltyPoints(reservation.user_id);
          loadUserReservations();
        },
        function () {
          toastr.error("Failed to cancel reservation.");
        }
      );
    }
  });
}

function decreaseUserLoyaltyPoints(user_id) {
  RestClient.get(`user/${user_id}`, function (user) {
    user.loyalty_points = user.loyalty_points - 1;
    RestClient.put(`user/${user.id}`, user, function () {
    });
  });
}
