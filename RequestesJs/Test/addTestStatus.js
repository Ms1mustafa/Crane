function checkedTests() {
  let allChecked = true;

  document.querySelectorAll(".radio").forEach((radio) => {
    if (radio.value === "1" && !radio.checked) {
      allChecked = false;
    }
  });

  return allChecked;
}

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

//***************Add Test Status************************ */
const postTestStatusUrl = "Requestes/Test/postTestStatus.php";

const submitBtn = document.getElementById("submitBtn");
submitBtn.addEventListener("click", (e) => {
  e.preventDefault();

  const equipmentID = getEquipmentID();
  const status = checkedTests() ? "available" : "unavailable";

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
      data.success
        ? showToastr("success", `Done`, false, false, "3000")
        : showToastr("error", `${data.message}`, false, false, "3000");
    } catch (error) {
      console.error("Error:", error);
    }
  }

  add();
});
