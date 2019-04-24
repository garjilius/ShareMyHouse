$(document).ready(function () {

    if (!localStorage.codiceFiscale) {
        while (document.firstChild) {
            document.removeChild(document.firstChild);
        }
        window.location = "errorPage.php";
    }
});