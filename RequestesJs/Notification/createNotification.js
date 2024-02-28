function createNotification(url, requestData) {
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

  return create() ? true : false;
}
