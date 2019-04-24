function logout() {
    localStorage.removeItem("codiceFiscale");
    window.location = "index.php";
}