async function GetUserEquipment() {
  let GetUserEquipmentUrl = "Requestes/Account/GetUserEquipment.php";

  const token = getTokenFromCookies();

  const requestData = {
    token: token,
  };

  try {
    const response = await axios.post(GetUserEquipmentUrl, requestData, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });

    const data = response.data;
    if (data.success) {
      return data.data.equipmentID === getEquipmentID()
        ? ""
        : (window.location.href = "index.php");
    } else {
      return;
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

GetUserEquipment();

const GetTest = "Requestes/Test/GetTest.php";

async function Get(requestData, priority) {
  try {
    const response = await axios.post(GetTest, requestData ?? {});

    const data = response.data;
    if (data.success) {
      data.data.forEach((type) => {
        const tr = document.createElement("tr");

        const blankTd = document.createElement("td");
        tr.appendChild(blankTd);

        const acceptRadio = document.createElement("input");
        acceptRadio.type = "radio";
        acceptRadio.name = type.token;
        acceptRadio.value = "0";
        acceptRadio.className = "radio";
        const acceptTd = document.createElement("td");
        acceptTd.appendChild(acceptRadio);
        tr.appendChild(acceptTd);

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
        priority.appendChild(tr);
      });
    } else {
      console.log("Error: " + data.message);
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

const priority1 = document.getElementById("priority1");
const priority2 = document.getElementById("priority2");
const priority3 = document.getElementById("priority3");

Get({ priority: "high" }, priority1);
Get({ priority: "medium" }, priority2);
Get({ priority: "low" }, priority3);
