async function getCheckedToday() {
  const getCheckedTodayURL = "Requestes/Equipment/GetCheckedToday.php";
  const table = document.getElementById("table");

  try {
    const response = await axios.get(getCheckedTodayURL);
    const data = response.data;
    if (data.success) {
      data.data.forEach((equipment) => {
        const tr = document.createElement("tr");

        const equipmentNameTd = document.createElement("td");
        equipmentNameTd.textContent = `${equipment.asset_type} / ${equipment.description}`;
        tr.appendChild(equipmentNameTd);

        const equipmentStatusTd = document.createElement("td");
        equipmentStatusTd.textContent = equipment.status;
        tr.appendChild(equipmentStatusTd);

        const actionTd = document.createElement("a");
        actionTd.textContent = "عرض التفاصيل";
        actionTd.href = equipment.url;
        tr.appendChild(actionTd);

        table.appendChild(tr);
      });
    } else {
      const tr = document.createElement("tr");
      const td = document.createElement("td");
      td.setAttribute("colspan", "3");
      td.textContent = "No data available yet";
      tr.appendChild(td);
      table.appendChild(tr);
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

getCheckedToday();
