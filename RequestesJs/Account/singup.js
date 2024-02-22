let PostAccountUrl = "Requestes/Account/PostAccount.php";

const createbtn = document.getElementById("createBtn");
createbtn.addEventListener("click", (e) => {
  e.preventDefault();

  const username = document.getElementById("username").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const typeId = document.getElementById("userType").value;
  const equipmentID = document.getElementById("equipment").value;

  const requestData = {
    username: username,
    password: password,
    email: email,
    typeId: typeId,
    equipmentID: equipmentID,
  };

  async function create() {
    try {
      const response = await axios.post(PostAccountUrl, requestData, {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      });

      const data = response.data;
      data.success
        ? showToastr("success", `Done`, false, true, "3000")
        : showToastr("error", `${data.message}`, false, true, "3000");
    } catch (error) {
      console.error("Error:", error);
    }
  }

  create();
});
