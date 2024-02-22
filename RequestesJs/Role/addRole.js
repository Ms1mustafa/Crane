const checkboxList = document.querySelectorAll(".page-checkbox");

checkboxList.forEach((checkbox) => {
  checkbox.addEventListener("change", async (event) => {
    const pageId = event.target.value;
    const typeId = getUserTypeFromURL(); // Implement this function to get user type from URL
    const isChecked = event.target.checked;

    try {
      if (isChecked) {
        // Add permission
        const response = await makeRequest("POST", "addPermissionAPI.php", {
          typeId,
          pageId,
        });
        if (response.success) {
          showNotification("success", "Permission added successfully");
        } else {
          showNotification("error", "Failed to add permission");
          event.target.checked = false; // Revert checkbox state if adding permission failed
        }
      } else {
        // Delete permission
        const response = await makeRequest("POST", "deletePermissionAPI.php", {
          typeId,
          pageId,
        });
        if (response.success) {
          showNotification("success", "Permission removed successfully");
        } else {
          showNotification("error", "Failed to remove permission");
          event.target.checked = true; // Revert checkbox state if removing permission failed
        }
      }
    } catch (error) {
      console.error("Error:", error);
      showNotification("error", "Failed to perform permission operation");
      event.target.checked = !isChecked; // Revert checkbox state if permission operation failed
    }
  });
});

// Function to make API requests
async function makeRequest(method, url, data) {
  try {
    const response = await axios({
      method: method,
      url: url,
      data: data,
      headers: {
        "Content-Type": "application/json",
      },
    });
    return response.data;
  } catch (error) {
    throw error;
  }
}

// Function to show notifications
function showNotification(type, message) {
  // Implement this function to show a notification with SweetAlert or any other library
}

// Function to get user type from URL
function getUserTypeFromURL() {
  // Implement this function to extract user type from the URL
}
