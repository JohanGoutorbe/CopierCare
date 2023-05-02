const addPieceBtn = document.querySelector("#AddPieceBtn")

function AddPieceFormFunction() {
    const section = document.querySelector("section");
    if (section.style.display === "none") {
        section.style.display = 'block' // Show AddPieceForm
    } else {
        section.style.display = 'none' // Hide AddPieceForm
    }
};

addPieceBtn.addEventListener('click', () => {
    AddPieceFormFunction()
})

// Fenêtre modale de modification de pièce

let modal = null

const openModal = function (e) {
    e.preventDefault()
    const target = document.querySelector(e.target.getAttribute('href'))
    target.style.display = null
    target.removeAttribute('aria-hidden')
    target.setAttribute('aria-modal', 'true')
    modal = target
    modal.addEventListener('click', closeModal)
}

const closeModal = function (e) {
    if (modal === null) return
    e.preventDefault()
    modal.style.display = "none"
    modal.setAttribute('aria-hidden','true')
    modal.removeAttribute('aria-modal')
    modal.removeEventListener('click', closeModal)
    modal = null
}

const stopPropagation = function (e) {
    e.stopPropagation();
}

document.querySelector('.js-modal').addEventListener('click', openModal)