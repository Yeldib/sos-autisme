class Diaporama {
  constructor(elements, images, description, durée) {
    this.elements = elements;
    this.images = images;
    this.durée = durée;
    this.description = description;

    this.diapoId = document.getElementById(this.elements);
    this.eltImg = this.diapoId.querySelector("img");
    this.eltPara = this.diapoId.querySelector("#texte-diaporama");
    this.eltPrec = this.diapoId.querySelector(".btn-diaporama .btn-prec");
    this.eltSuiv = this.diapoId.querySelector(".btn-diaporama .btn-suiv");
    this.eltPause = this.diapoId.querySelector(
      ".btn-diaporama .fa-pause"
    );

    this.timer = null;
    this.nombreImage = 0;
    this.nombreDescription = 0;

    //Evénements
    document.addEventListener("keydown", (e) => {
      this.keyboard(e);
    });

    this.eltPrec.addEventListener("click", () => {
      this.imgPrec();
    });

    this.eltSuiv.addEventListener("click", () => {
      this.imgSuiv();
    });

    this.eltPause.addEventListener("click", () => {
      this.imageScroll();
    });

    this.imageScroll();
  }

  /* Méthode bouton prev + Description de l'image */
  imgPrec() {
    this.nombreImage--;
    this.nombreDescription--;
    if (this.nombreImage < 0 && this.nombreDescription < 0) {
      this.nombreImage = this.images.length - 1;
      this.nombreDescription = this.description.length - 1;
    }
    this.eltImg.src = this.images[this.nombreImage];
    this.eltPara.textContent = this.description[this.nombreDescription];
  }


  /* Méthode bouton next + Description de l'image */
  imgSuiv() {
    this.nombreImage++;
    this.nombreDescription++;
    if (this.nombreImage > this.images.length - 1 && this.nombreDescription > this.description.length - 1) {
      this.nombreImage = 0;
      this.nombreDescription = 0;
    }
    this.eltImg.src = this.images[this.nombreImage];
    this.eltPara.textContent = this.description[this.nombreDescription];
  }

  /* Méthode clavier */
  keyboard(e) {
    switch (e.keyCode) {
      case 39: // gauche
        this.imgSuiv();
        break;
      case 37: // droite
        this.imgPrec();
        break;
      case 32: // espace
        this.imageScroll();

        break;
    }
  }

  /* Méthode diaporama auto + bouton play / pause */
  // Utilisation de bind() pour lier les élements
  imageScroll() {
    if (this.timer) {
      clearInterval(this.timer);
      this.timer = null;
      this.eltPause.className = "fas fa-play";
    } else {
      this.timer = setInterval(this.imgSuiv.bind(this), this.durée);
      this.eltPause.className = "fas fa-pause";
    }
  }
}

// Param 1- Mettre votre id 
// Param 2- Inserer vos images
// Param 3- Afficher déscription de l'image (option)
// Param 4- Choisir une durée


const slide = new Diaporama(
  "diaporama",
  [
    "/images/banniere_autisme.jpg",
    "/images/capture.png",
    "/images/girlBulle.jpg"
  ],

  [
    `QUI SOMMES-NOUS ET QUEL EST LE BUT DE CE SITE ?  Nous sommes parents de deux enfants diagnostiqués autistes et le but de ce site est qu'en quelques clics les parents puissent trouver tous les professionnels de l'autisme dont ils ont besoin`,
    "COMMENT UTILISER LE SITE ? C'est très simple, il vous suffit dans la barre de recherche ci-dessous de selectionner une profession et un département puis de cliquer sur le bouton rechercher.",
    "COMMENT NOUS AIDER ? Diffuser au maximum autour de vous l’adresse de ce site. Vous connaissez des professionnels de l’autisme ? N’hésitez pas à nous contacter."
  ],

  10000
);