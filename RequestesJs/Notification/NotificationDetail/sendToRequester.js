async function OperatorNotificationDone() {
  const requestData = {
    token: getUrlParam("noti"),
  };
  try {
    const response = await axios.post(
      "Requestes/Notification/OperatorNotificationDone.php",
      requestData,
      { headers: { "Content-Type": "application/x-www-form-urlencoded" } }
    );
    return response.data.success;
  } catch (error) {
    console.error("Error:", error);
    return false;
  }
}

async function sendToRequester() {
  const notification = await getEquipmentDetail();

  const NotificationData = {
    receiver_token: "gL47q3Wb86v1ssl",
    receiverType: "requester",
    url: "equipmenDetail.html",
    data: {
      equipment_token: notification.equipment_token,
      asset_type: notification.asset_type,
      description: notification.description,
    },
  };

  const operatorNotificationDone = await OperatorNotificationDone();

  if (
    createNotification(
      "Requestes/Notification/createNotification.php",
      NotificationData
    ) &&
    operatorNotificationDone
  ) {
    showToastr("success", `Done`, false, true, "3000");
    document.querySelector(".btn").disabled = true;
    setTimeout(function () {
      window.location.href = "operitionNotif.html";
    }, 3000);
  } else {
    showToastr("error", `Error happened`, false, true, "3000");
  }
}
