const userType = document.getElementById("userType");
const GetUserTypeUrl = "Requestes/UserType/GetUserType.php";

async function Get() {
  try {
    const response = await axios.get(GetUserTypeUrl);

    const data = response.data;
    if (data.success) {
      data.data.forEach((type) => {
        const option = document.createElement("option");
        option.value = type.name;
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

Get();
