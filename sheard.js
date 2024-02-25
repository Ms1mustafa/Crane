"use strict";

function showToastr(status, title, closeButton, progressBar, timeOut) {
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    showCloseButton: closeButton,
    timer: timeOut,
    timerProgressBar: progressBar,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    },
  });
  Toast.fire({
    icon: status,
    title: title,
  });
}

// Capitalize the first letter
function capitalizeFirst(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

// Check if user is logged in

function getTokenFromCookies() {
  // Get all cookies
  const cookies = document.cookie.split(";");

  // Loop through each cookie
  for (let i = 0; i < cookies.length; i++) {
    const cookie = cookies[i].trim();
    // Check if the cookie starts with "token="
    if (cookie.startsWith("token=")) {
      // Return the value of the token cookie
      return cookie.substring("token=".length); // Extract the token value
    }
  }
  return null; // Token not found in cookies
}

const getIsLoggedInUrl = "Requestes/Account/getIsLoggedIn.php";

function getIsLoggedIn() {
  const requestData = {
    token: getTokenFromCookies(),
  };

  async function isLoggedIn() {
    const response = await axios.post(getIsLoggedInUrl, requestData, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });

    const data = response.data;
    data.success ? "" : (window.location.href = "logout.php");
  }

  isLoggedIn();
}
