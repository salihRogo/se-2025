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
  data.reservation_time = `${reservationDate} ${reservationTime}:00`;

  console.log(data);

  RestClient.post("reservation", data, function (response) {
    window.setTimeout(1000);
    toastr.success(
      `Reservation confirmed for ${guestNumber} guests on ${reservationDate} at ${reservationTime}.`
    );
  }, function() {
    toastr.warning(
      `You have to be logged in in order to reserve a spot.`
    );
  });
}
