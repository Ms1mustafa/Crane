function checkedTests() {
  let allChecked = true;

  document.querySelectorAll(".radio").forEach((radio) => {
    if (radio.value === "1" && !radio.checked) {
      allChecked = false;
    }
  });

  return allChecked;
}

//***************Get Equipment ID************************ */
function getEquipmentID() {
  const url = new URL(window.location.href);

  // Get the value of the 'test' parameter
  const testValue = url.searchParams.get("test");

  // Check if the 'test' parameter exists and has a value
  if (testValue !== null) {
    return testValue;
  } else {
    return (window.location.href = "index.php");
  }
}

getEquipmentID();

//***************Get Equipment************************ */

async function GetUserEquipment() {
  let GetUserEquipmentUrl = "Requestes/Equipment/GetEquipmentByUserToken.php";

  const token = getTokenFromCookies();

  const requestData = {
    token: token,
    // get: "*",
  };

  try {
    const response = await axios.post(GetUserEquipmentUrl, requestData, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });

    const data = await response.data;
    if (data.success) {
      return data.data.token;
    } else {
      return;
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

//***************Get User Test Status Today************************ */
let submited = false;
async function GeUserTestStatusTody() {
  let GeUserTestStatusTodyUrl = "Requestes/Test/GeUserTestStatusTody.php";

  const requestData = {
    equipmentID: getEquipmentID(),
  };

  try {
    const response = await axios.post(GeUserTestStatusTodyUrl, requestData, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });

    const data = response.data;
    return data.success ? (submited = true) : (submited = false);
  } catch (error) {
    console.error("Error:", error);
  }
}
GeUserTestStatusTody();

//***************Add Test Status************************ */
const postTestStatusUrl = "Requestes/Test/postTestStatus.php";

const submitBtn = document.getElementById("submitBtn");
submitBtn.addEventListener("click", (e) => {
  e.preventDefault();
  GeUserTestStatusTody();
  if (submited) {
    showToastr(
      "error",
      `you already submited the form today`,
      false,
      true,
      "3000"
    );
    setTimeout(function () {
      window.location.href = "index.php";
    }, 3000);
    return;
  }

  const equipmentID = getEquipmentID();
  const status = checkedTests() ? "accepted" : "rejected";

  const requestData = {
    equipmentID: equipmentID,
    status: status,
  };

  async function add() {
    try {
      const response = await axios.post(postTestStatusUrl, requestData, {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      });

      const data = response.data;
      if (data.success) {
        const NotificationData = {
          receiverType: "operation",
          url: "equipmenDetail.html",
          // data: {
          //   equipment_name: "test",
          //   description: "rrrr",
          // },
        };
        createNotification(
          "Requestes/Notification/createNotification.php",
          NotificationData
        );

        showToastr("success", `Done`, false, true, "3000");
        //disble button
        submitBtn.disabled = true;
        setTimeout(function () {
          window.location.href = "index.php";
        }, 3000);
      } else {
        showToastr("error", `${data.message}`, false, false, "3000");
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }

  add();
});
