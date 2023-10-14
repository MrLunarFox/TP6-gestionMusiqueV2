// on récupère le bouton de chargement image
const btnCharger = document.getElementById("chargePochette");
btnCharger.addEventListener("click", lanceParcourir, false);

// on récupère le champ d'upload
const fileUpload = document.getElementById("album_imageFile");
fileUpload.addEventListener("change", afficheImage, false);

// on récupère le champ img qui affiche l'image
const imageAffichee = document.getElementById("imageAffichee");

function lanceParcourir() {
    fileUpload.click();
}

function afficheImage() {
    const imageCharger = this.files[0];
    const urlImageCharger = URL.createObjectURL(imageCharger);
    imageAffichee.setAttribute("src", urlImageCharger);
    
}