let isPasswordShow = false;
let showHidePassword = () => {
  if (isPasswordShow) {
    $("#password").attr("type", "password");
    $("#inputPassGroupBtn").addClass("fa-eye");
    $("#inputPassGroupBtn").removeClass("fa-eye-slash");
  } else {
    $("#password").attr("type", "text");
    $("#inputPassGroupBtn").addClass("fa-eye-slash");
    $("#inputPassGroupBtn").removeClass("fa-eye");
  }
  isPasswordShow = !isPasswordShow;
};
