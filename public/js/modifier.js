document.addEventListener("DOMContentLoaded", function () {

    // ========= AJOUT =========
    const btnAjouter = document.getElementById("btn-ajouter");
    const formAjout = document.getElementById("form-ajout");
    const btnAnnulerAjout = document.getElementById("btn-annuler-ajout");

    if (btnAjouter) {
        btnAjouter.addEventListener("click", function () {
            formAjout.style.display = "table-row";
        });
    }

    if (btnAnnulerAjout) {
        btnAnnulerAjout.addEventListener("click", function () {
            formAjout.style.display = "none";
        });
    }

    // ========= MODIFIER =========
    document.querySelectorAll(".btn-modifier").forEach(button => {
        button.addEventListener("click", function () {

            const id = this.dataset.id;
            const nom = this.dataset.nom;

            const row = document.getElementById("form-row-" + id);
            const input = document.getElementById("input-" + id);

            if (row && input) {
                row.style.display = "table-row";
                input.value = nom;
            }
        });
    });

    // ========= ANNULER MODIF =========
    document.querySelectorAll(".btn-annuler").forEach(button => {
        button.addEventListener("click", function () {

            const id = this.dataset.id;
            const row = document.getElementById("form-row-" + id);

            if (row) {
                row.style.display = "none";
            }
        });
    });

    // ========= SUPPRIMER =========
    document.querySelectorAll(".btn-supprimer").forEach(link => {
        link.addEventListener("click", function (e) {
            if (!confirm("Supprimer cette catégorie ?")) {
                e.preventDefault();
            }
        });
    });

});
