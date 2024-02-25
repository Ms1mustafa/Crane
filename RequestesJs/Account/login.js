function login(LoginUrl, requestData) {
  async function create() {
    try {
      const response = await axios.post(LoginUrl, requestData, {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      });

      const data = response.data;
      data.success
        ? (showToastr(
            "success",
            `Welcome back, ${requestData.username}`,
            false,
            true,
            "3000"
          ),
          setTimeout(function () {
            window.location.href = "index.php"; // Replace "index.php" with the URL of your index page
          }, 3000))
        : showToastr("error", `${data.message}`, false, true, "3000");
    } catch (error) {
      console.error("Error:", error);
    }
  }
  create();
}

const loginBtn = document.getElementById("loginBtn");
loginBtn.addEventListener("click", (e) => {
  e.preventDefault();

  let LoginUrl = "Requestes/Account/Login.php";

  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  const requestData = {
    username: username,
    password: password,
  };

  login(LoginUrl, requestData);
});
