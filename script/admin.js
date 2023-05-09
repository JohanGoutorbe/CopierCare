const AddUserBtn = document.querySelector("#AddUserBtn")

function AddPieceFormFunction() {
    const section = document.querySelector("section");
    if (section.style.display === "none") {
        section.style.display = 'block' // Show AddPieceForm
    } else {
        section.style.display = 'none' // Hide AddPieceForm
    }
};

AddUserBtn.addEventListener('click', () => {
    AddPieceFormFunction()
})