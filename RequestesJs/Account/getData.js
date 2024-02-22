// *******************Get userTypes********************* */

const userType = document.getElementById("userType");

async function GetUserType() {
  const GetUserTypeUrl = "Requestes/UserType/GetUserType.php";

  try {
    const response = await axios.get(GetUserTypeUrl);

    const data = response.data;
    if (data.success) {
      data.data.forEach((type) => {
        const option = document.createElement("option");
        option.value = type.id;
        option.textContent = capitalizeFirst(type.name);
        userType.appendChild(option);
      });
    } else {
      showToastr("error", `${data.message}`, false, false, "3000");
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

GetUserType();

// *******************Get Equipment********************* */

const equipment = document.getElementById("equipment");

async function GetEquipment() {
  const GetEquipmentUrl = "Requestes/Equipment/GetEquipment_singup.php";

  try {
    const response = await axios.get(`${GetEquipmentUrl}`);

    const data = response.data;
    if (data.success) {
      data.data.forEach((type) => {
        const option = document.createElement("option");
        option.value = type.id;
        option.textContent = `${capitalizeFirst(
          type.asset_type
        )} / ${capitalizeFirst(type.description)}`;
        equipment.appendChild(option);
      });
    } else {
      showToastr("error", `${data.message}`, false, false, "3000");
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

function clearEquipment() {
  equipment.innerHTML = "";
  const option = document.createElement("option");
  option.value = "";
  option.selected = true;
  option.disabled = true;
  option.textContent = "Select User Equipment";
  equipment.appendChild(option);
}

userType.addEventListener("change", () => {
  if (
    userType.options[userType.selectedIndex].text.toLowerCase() === "driver"
  ) {
    equipment.disabled = false;
    equipment.style.display = "block";
    GetEquipment();
  } else {
    equipment.disabled = true;
    equipment.style.display = "none";
    clearEquipment();
  }
});
