check_user_role = function () {
  const userRole = window.localStorage.getItem("role");
  if (userRole === null) {
    const userMenuItems = document.querySelectorAll("#user-menu");
    userMenuItems.forEach((item) => {
      item.classList.remove("d-none");
    });
    const adminMenuItems = document.querySelectorAll("#admin-menu");
    adminMenuItems.forEach((item) => {
      item.classList.add("d-none");
    });
  } else if (userRole === "admin") {
    const userMenuItems = document.querySelectorAll("#user-menu");
    userMenuItems.forEach((item) => {
      item.classList.add("d-none");
    });
    const adminMenuItems = document.querySelectorAll("#admin-menu");
    adminMenuItems.forEach((item) => {
      item.classList.remove("d-none");
    });
  } else if (userRole === "user"){
    const userMenuItems = document.querySelectorAll("#user-menu");
    userMenuItems.forEach((item) => {
      item.classList.remove("d-none");
    });
    const adminMenuItems = document.querySelectorAll("#admin-menu");
    adminMenuItems.forEach((item) => {
      item.classList.add("d-none");
    });
  }
};
