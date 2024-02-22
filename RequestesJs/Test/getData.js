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
        acceptRadio.value = "1";
        acceptRadio.className = "radio";
        const acceptTd = document.createElement("td");
        acceptTd.appendChild(acceptRadio);
        tr.appendChild(acceptTd);

        const rejectRadio = document.createElement("input");
        rejectRadio.type = "radio";
        rejectRadio.name = type.token;
        rejectRadio.value = "0";
        rejectRadio.className = "radio";
        const rejectTd = document.createElement("td");
        rejectTd.appendChild(rejectRadio);
        tr.appendChild(rejectTd);

        const nameTd = document.createElement("td");
        nameTd.textContent = type.name;
        tr.appendChild(nameTd);

        // Append the table row to your table element
        priority.appendChild(tr);
      });
    } else {
      //   console.log("Error: " + data.message);
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

let allChecked = true;

document.querySelectorAll(".radio").forEach((radio) => {
  if (radio.value === "1" && !radio.checked) {
    allChecked = false;
  }
});

if (allChecked) {
  console.log("All radio buttons with value '1' are checked.");
} else {
  console.log("Not all radio buttons with value '1' are checked.");
}
