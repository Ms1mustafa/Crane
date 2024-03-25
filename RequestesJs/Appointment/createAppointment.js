const url = "../Requestes/Appointment/CreateAppointment.php";

const createbtn = document.getElementById("createBtn");
createbtn.addEventListener("click", (e) => {
  e.preventDefault();

  const created_by = getTokenFromCookies();
  const equipment = getUrlParam("eq");
  const title = document.getElementById("title").value;
  const area = document.getElementById("area").value;
  const location = document.getElementById("location").value;
  const work_type = document.getElementById("work_type").value;

  const requestData = {
    created_by: created_by,
    equipment: equipment,
    start_date: start_dateValue,
    end_date: end_dateValue,
    title: title,
    area: area,
    location: location,
    work_type: work_type,
    color: currColor,
  };

  async function create() {
    try {
      const response = await axios.post(url, requestData, {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      });

      const data = response.data;
      if (data.success) {
        showToastr(
          "success",
          `Appointment created successfully`,
          false,
          false,
          "3000"
        );
        getAppointments();
      } else {
        showToastr("error", `${data.message}`, false, false, "3000");
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }

  create();
});
