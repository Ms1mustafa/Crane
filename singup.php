<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SignIn&SignUp</title>
  <link rel="stylesheet" type="text/css" href="css/Sing.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="RequestesJs/Account/singup.js" defer></script>
  <script src="RequestesJs/Account/getUserTypes.js" defer></script>
  <script src="toaster/toastr.min.js"></script>
  <link rel="stylesheet" href="toaster/toastr.min.css" />
  <script src="sheard.js" defer></script>

</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" class="sign-in-form">
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" id="username" />
          </div>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" placeholder="Email" id="email" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" id="password" />
          </div>

          <select class="input-field" id="userType" name="type" required>
            <option value="" disabled selected>Select User Type</option> -->
          </select>

          <select class="input-field" id="equipment" name="type" required>
            <option value="" disabled selected>Select User Equipment</option>
            <option value="1">1</option>

          </select>

          <input type="submit" value="Login" class="btn solid" id="createBtn" />

          <p class="social-text">Or Sign up with social platforms</p>

        </form>

      </div>
    </div>
    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here?</h3>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio minus natus est.</p>
          <button class="btn transparent" id="sign-up-btn"></button>
        </div>
        <img src="./img/log.svg" class="image" alt="">
      </div>
    </div>
  </div>
</body>

</html>