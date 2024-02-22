const url = "Requestes/Equipment/PostEquipment.php";

const createbtn = document.getElementById("createBtn");
createbtn.addEventListener("click", (e) => {
  e.preventDefault();

  const username = document.getElementById("username").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const type = document.getElementById("userType").value;
  const equipment = document.getElementById("equipment").value;

  const requestData = {
    username: username,
    password: password,
    email: email,
    type: type,
    equipment: equipment,
  };

  async function create() {
    try {
      const response = await axios.post(url, requestData, {
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

  create();
});
