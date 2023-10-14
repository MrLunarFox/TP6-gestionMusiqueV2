// on récupère le bouton de chargement image
const btnCharger = document.getElementById("chargePochette");
btnCharger.addEventListener("click", lanceParcourir, false);

// on récupère le champ d'upload
const fileUpload = document.getElementById("album_imageFile");

function lanceParcourir() {
    fileUpload.click();
}