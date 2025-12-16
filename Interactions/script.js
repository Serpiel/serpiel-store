<<<<<<< HEAD
function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var errorMsg = document.getElementById("error_msg");

    if (password !== confirmPassword) {
        errorMsg.textContent = "Passwords don't match";
        errorMsg.style.color = "red";
        return false;
    }
    return true;
=======
function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var errorMsg = document.getElementById("error_msg");

    if (password !== confirmPassword) {
        errorMsg.textContent = "Passwords don't match";
        errorMsg.style.color = "red";
        return false;
    }
    return true;
>>>>>>> 2fca341a50f4c42f33410b1d0aa0c44a74c8e042
}