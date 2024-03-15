async function getName() {
  const getNameUrl = "../Requestes/Account/getNameByToken.php";
  const userToken = getTokenFromCookies();

  //   const username = document.getElementById("usermame");

  try {
    const response = await axios.post(
      getNameUrl,
      { token: userToken }, // Pass token as data object
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );

    const data = response.data;
    if (username)
      username.innerHTML = `User Name: ${capitalizeFirst(data.data)}`; // Corrected typo: "seccess" to "success"
    console.log(data);
  } catch (error) {
    console.error("Error:", error);
    throw error; // Rethrow the error to be caught by the caller
  }
}

getName();

// Get Equipment Details
async function getEquipmentDetails() {
  const getEquipmentDetailsUrl = "../Requestes/Equipment/GetEquipment.php";
  requestData = {
    token: getUrlParam("eq"),
  };

  const typeAset = document.getElementById("typeAset");
  try {
    const response = await axios.post(getEquipmentDetailsUrl, requestData, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    const data = response.data;

    if (data.success) {
      //   console.log(data.data);
      typeAset.textContent = `Type Aset: ${data.data.asset_type}`;
    }
  } catch {
    console.error("Error:", error);
  }
}
getEquipmentDetails();
