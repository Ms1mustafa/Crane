"use strict";

function showToastr(status, title, closeButton, progressBar, timeOut) {
  toastr[status](title);
  toastr.options = {
    closeButton: closeButton,
    progressBar: progressBar,
    timeOut: timeOut,
    newestOnTop: true,
  };
}

// Capitalize the first letter
function capitalizeFirst(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
