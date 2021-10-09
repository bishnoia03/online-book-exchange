<?php 
session_start();
if(isset($_SESSION["USER_ID"] )){
  ?>
   <script>
       window.location.href= "./admin/";
   </script>
  <?php 
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - UPPCL</title>

    <!-- inlcude bootstrap -->
    <link rel="stylesheet" href="./css/bootstrap.min.css" />

    <!-- include custom css -->
    <link rel="stylesheet" href="./css/style.css" />

    <!-- toster css -->
    <link rel="stylesheet" href="./css/toastr.min.css" />
  </head>
  <body>
    <!-- main login page div -->
    <div class="row">
      <!-- login page left part -->
      <div class="col-lg-4 col-sm-12 col-md-6 text-white login__left__part">
        <h3 class="p-4">Hola, Welcome Back</h3>
        <div class="card login__form__card">
          <div class="card-body">
            <h3 class="p-4 text-dark"><i class="fa fa-sign-in"></i> Login</h3>

            <!-- form -->
            <form action="" method="post" onsubmit="return validateForm()">
              <!-- username field-->
              <div class="input-group flex-nowrap">
                <div class="input-group-text">
                  <i class="fa fa-envelope"></i>
                </div>
                <input
                  type="email"
                  id="username"
                  autocomplete="off"
                  name="username"
                  class="form-control"
                  placeholder="Username"
                  aria-label="Username"
                  aria-describedby="addon-wrapping"
                  required
                />
              </div>
              <!-- username end-->

              <!-- password field -->
              <div class="input-group flex-nowrap mt-4">
                <div class="input-group-text">
                  <i class="fa fa-key"></i>
                </div>
                <input
                  type="password"
                  id="password"
                  autocomplete="off"
                  name="password"
                  class="form-control"
                  placeholder="Password"
                  aria-label="password"
                  oncopy="return false"
                  onpaste ="return false"
                  oncut ="return false"
                  aria-describedby="addon-wrapping"
                  required
                />
                <div class="input-group-text" onclick="showHidePassword()">
                  <i
                    class="fa fa-eye view__hide__password"
                    id="inputPassGroupBtn"
                  ></i>
                </div>
              </div>
              <!-- username end-->

              <!-- login  btn -->
              <button
                type="submit"
                class="btn btn-block mt-4 text-light login__btn"
              >
                <i class="fa fa-check-circle"></i> Login
              </button>
            </form>

            <!-- forgot password -->
            <div class="row mt-4">
              <div class="col-md-12 text-dark font-weight-bold">
                <span class="bold__font"
                  >Forgot your password ?
                  <span class="primary__text__color bold__font"
                    >click here</span
                  >
                </span>
              </div>
            </div>
            <!-- forgot password -->
          </div>
        </div>
      </div>

      <!-- login page right part -->
      <div class="col-md-6"></div>
    </div>
    <!-- main login page div -->

    <!-- external js script -->

    <!-- jquert -->
    <script src="./js/jquery.js"></script>

    <!-- bootstrap js -->
    <script src="./js/bootstrap.bundle.min.js"></script>

    <!-- fontawesome cdn -->
    <script src="https://use.fontawesome.com/4c38b3bc58.js"></script>

    <!-- toster js -->
    <script src="./js/toastr.min.js"></script>

    <!-- custom login js -->
    <script src="./js/login.js"></script>

    <!-- toster -->
    <script>
      toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
      };
      // toastr.error('Payment Date is Not Valid.',"Oops!");
    </script>
    <!-- toast -->

    <script>
      function validateForm() {
        let userName = $("#username").val();
        let password = $("#password").val();
        if (!userName) {
          $("#username").css("border-color", "#f00");
          toastr.error("Username field required.", "Oops!");
          return false;
        } else if (!userName.includes("@") || !userName.includes(".")) {
          $("#username").css("border-color", "#f00");
          toastr.error("invalid username.", "Oops!");
          return false;
        } else if (!password) {
          $("#username").css("border-color", "#ced4da");
          $("#password").css("border-color", "#f00");
          toastr.error("Password field required.", "Oops!");
          return false;
        } 

        $("#username").css("border-color", "#ced4da");
        $("#password").css("border-color", "#ced4da");
        return true;
        
      }


      // show error toaster 
      function showErrorToaster(msg){
        toastr.error(`${msg}`, "Oops!");
      }
    </script>
    


<?php 

  if(isset($_POST["username"]) && isset($_POST["password"])){
      
      $username = $_POST["username"];
      $password = $_POST["password"];
      // if username ans password fields are not empty
      if(!empty($username) && !empty($password)){
        include "./api/helper/ValidationHelper.php";
        if(!ValidationHelper::validateEmail($username)){
            showErrorToaster("username is not valid");
        }else{
             include "./api/Authentication.php";
             include "./api/db.php";
             $md5Password = md5($password);
             $auth = new Authentication($conn);
             $result = $auth->checkUserAutentication($username,$md5Password);
            //  if user authentication failed
             if(!count($result)){
                    ?>
                       <script>
                          showErrorToaster("Authection failed!");
                        </script>
                    <?php
             }else{
              //  if user authentication success 
              $_SESSION["USER_ID"]  = $result[0]["USER_ID"];
              $_SESSION["USER_FIRST_NAME"]  = $result[0]["USER_FIRST_NAME"];
              $_SESSION["USER_LAST_NAME"]  = $result[0]["USER_LAST_NAME"];
              $_SESSION["USER_EMAIL"]  = $result[0]["USER_EMAIL"];
              $_SESSION["USER_MOBILE"]  = $result[0]["USER_MOBILE"];
              $_SESSION["USER_TYPE"]  = $result[0]["USER_TYPE"];

              // redirection to admin dashboard page
              ?>
              <script>
                  window.location.href= "./admin/";
              </script>
             <?php 
             }
             
        }
        ?>
        <script>
          history.pushState({},"","");
        </script>
      <?php 
      }else{
        ?>
          <script>
            showErrorToaster("Username and password are required fields.");
            history.pushState({},"","");
          </script>
        <?php 
      }
  }

?>
  </body>
</html>
