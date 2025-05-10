function confirmReservation(shop_id) {
  const guestNumber = document.getElementById("number_of_guests").value;
  const reservationDate = document.getElementById("reservation-date").value;
  const reservationTime = document.getElementById("reservation-time").value;

  if (!guestNumber || !reservationDate || !reservationTime) {
    alert("Please fill out all fields.");
    return;
  }

  //   user_id = window.localStorage.getItem("user_id");
  //   console.log(user_id);

  data = {};
  data.shop_id = shop_id;
  data.user_id = 1;
  data.number_of_guests = guestNumber;
  data.reservation_time = `${reservationDate} ${reservationTime}:00`;

  console.log(data);

  RestClient.post("reservation", data, function (response) {
    alert(
      `Reservation confirmed for ${guestNumber} guests on ${reservationDate} at ${reservationTime}.`
    );
    window.location.hash = "#profile";
  });
}
