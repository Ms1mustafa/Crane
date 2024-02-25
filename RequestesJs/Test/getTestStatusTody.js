async function GetUserEquipment() {
  let GetUserEquipmentUrl = "Requestes/Test/GetTestStatusTody.php";
  const table = document.getElementById("table");
  try {
    const response = await axios.get(GetUserTypeUrl);

    const data = response.data;
    data.success?.data.forEach((type) => {
      const tr = document.createElement("tr");

      const equipmentName = document.createElement("input");
      equipmentName.type = "radio";
      equipmentName.name = type.token;
      equipmentName.value = "0";
      equipmentName.className = "radio";

      const rejectRadio = document.createElement("input");
      rejectRadio.type = "radio";
      rejectRadio.name = type.token;
      rejectRadio.value = "1";
      rejectRadio.className = "radio";
      const rejectTd = document.createElement("td");
      rejectTd.appendChild(rejectRadio);
      tr.appendChild(rejectTd);

      const nameTd = document.createElement("td");
      nameTd.textContent = type.name;
      tr.appendChild(nameTd);
      table.appendChild(tr);
    });
  } catch (error) {
    console.error("Error:", error);
  }
}

GetUserEquipment();
