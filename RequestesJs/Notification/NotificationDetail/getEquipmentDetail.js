const notificationToken = getUrlParam("noti");

const getEquipmentDetailURL =
  "Requestes/NotificationDetail/GetEquipmentDetail.php";

const requestData = {
  token: notificationToken,
};

const notificationDetail = document.getElementById("notification_detail");

async function getEquipmentDetai() {
  try {
    const response = await axios.post(getEquipmentDetailURL, requestData, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });

    const data = response.data;
    if (data.success) {
      const notification = data.data;
      const equipment = data.data2;
      notificationDetail.innerHTML = "";

      const htmlString = `
          <div class="notification unreaded">
            <div class="avatar"><img src="assets/images/lafarge.png"></div>
            <div class="text">
              <div class="text-top">
                ${
                  notification.username
                    ? `<p><span class="profil-name"> Driver : ${capitalizeFirst(
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
                    ? `<p>Description : ${notification.description}</p>`
                    : ""
                }</div>
              
                <div>${
                  equipment.vechicle_no
                    ? `<p>Vechicle No : ${equipment.vechicle_no}</p>`
                    : ""
                }</div>
                <div>${
                  equipment.owner ? `<p>Owner : ${equipment.owner}</p>` : ""
                }</div>
                <div>${
                  equipment.asset_number
                    ? `<p>Asset No : ${equipment.asset_number}</p>`
                    : ""
                }</div>
              </div>
              <div class="text-bottom">${formatDate(
                notification.start_date
              )}</div>
            </div>
          </div>
          <div class="notification unreaded">
          <div class="text">
            <div class="text-top">
                <p>
                  <span class="profil-name"> Status : ${capitalizeFirst(
                    equipment.equipmentStatus
                  )}</span>
                </p>
                <button class="btn solid">${
                  equipment.equipmentStatus === "accepted"
                    ? "Send to Requester"
                    : ".."
                }</button>
              </div>
            </div>
          </div>
        `;
      notificationDetail.insertAdjacentHTML("afterbegin", htmlString);
    } else {
      showToastr("error", `Error happened!`, false, false, "3000");
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

getEquipmentDetai();
