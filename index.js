const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const themeToggler = document.querySelector(".theme-toggler");

// Show sidebar
menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
})

// Hide sidebar
closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
})

// themeToggler.addEventListener('load', () => {
//     let sessionthemed = sessionStorage.getItem('theme');
//     if (sessionthemed = 'black') {
//         themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
//         themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
//     }
// })

// Change theme
themeToggler.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme-variables');
    
    themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
    themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');

    // let sessionthemed = sessionStorage.getItem('theme');
    // if (sessionthemed =  'white') {
    //     sessionStorage.setItem('theme', 'black');
    // }
    // if (sessionthemed = 'black') {
    //     sessionStorage.setItem('theme', 'white');
    // }
})