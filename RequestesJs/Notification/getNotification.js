async function getName() {
  const getNameUrl = "Requestes/Account/getNameByToken.php";
  const token = getTokenFromCookies();

  try {
    const response = await axios.post(
      getNameUrl,
      { token: token }, // Pass token as data object
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );

    const data = response.data;
    username?.innerHTML = capitalizeFirst(data.data); // Corrected typo: "seccess" to "success"
  } catch (error) {
    console.error("Error:", error);
    throw error; // Rethrow the error to be caught by the caller
  }
}

getName();

async function GetNotification() {
  let GetNotificationUrl = "Requestes/Notification/GetNotification.php";

  const notificationDetail = document.getElementById("notification_detail");

  try {
    const response = await axios.post(GetNotificationUrl, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });

    const data = response.data;

    if (data.success) {
      notificationDetail.innerHTML = "";

      data.data.forEach((notification) => {
        const htmlString = `
          <div class="notification unreaded" onclick="window.location.href = '${
            notification.url
          }'">
            <div class="avatar"><img src="assets/images/lafarge.png"></div>
            <div class="text">
              <div class="text-top">
                ${
                  notification.username
                    ? `<p><span class="profil-name"> From : ${capitalizeFirst(
                        notification.username
                      )}</span></p>`
                    : ""
                }
                <div><p>reacted to your recent post </p></div>
                <div>${
                  notification.reqNum
                    ? `<p>${notification.reqNum}<span class="unread-dot"></span> </p>`
                    : ""
                }</div>
                <div>${
                  notification.asset_type
                    ? `<p>Asset type : ${notification.asset_type}</p>`
                    : ""
                }</div>
                <div>${
                  notification.description
                    ? `<p> Description : ${notification.description}</p>`
                    : ""
                }</div>
              </div>
              <div class="text-bottom">${formatDate(
                notification.start_date
              )}</div>
            </div>
          </div>
        `;

        notificationDetail.insertAdjacentHTML("afterbegin", htmlString);
      });
      const notificationNumber = document.getElementById("notificationNumber");
      notificationNumber.innerHTML = data.data.length;
    } else {
      notificationDetail.innerHTML = `<p>No Notifications</p>`;

      return;
    }
  } catch (error) {
    console.error("Error:", error);
  }
}
GetNotification();
setInterval(GetNotification, 5000);
