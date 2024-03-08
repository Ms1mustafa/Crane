"use strict";

//********************** Formater ************************ */

// Format date
function formatDate(inputDate) {
  const currentTime = Date.now(); // Current Unix timestamp in milliseconds
  const inputTime = new Date(inputDate).getTime(); // Convert input date to Unix timestamp in milliseconds

  const timeDiff = currentTime - inputTime;
  const minute = 60 * 1000; // milliseconds
  const hour = 60 * minute;
  const day = 24 * hour;

  if (!inputDate) return inputDate;

  if (timeDiff < minute) {
    return "Just now";
  } else if (timeDiff < hour) {
    const minutesAgo = Math.floor(timeDiff / minute);
    return minutesAgo + " min ago";
  } else if (timeDiff < 2 * hour) {
    return "An hour ago";
  } else if (timeDiff < day) {
    const hoursAgo = Math.floor(timeDiff / hour);
    return hoursAgo + " hours ago";
  } else if (timeDiff < 2 * day) {
    return "Yesterday";
  } else {
    return new Date(inputTime).toLocaleDateString("en-GB", {
      day: "numeric",
      month: "short",
      year: "numeric",
    });
  }
}

// first letter to uppercase
function capitalizeFirst(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

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

//Get from url
function getUrlParam(paramName) {
  const urlParams = new URLSearchParams(window.location.search);
  const paramValue = urlParams.get(paramName);
  return paramValue ? paramValue.replace(/^\??[^=]*=/, "") : null;
}
