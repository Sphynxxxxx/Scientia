
//for mobile menu
const toggleButton = document.querySelector('.mobile-menu-toggle');
const header = document.querySelector('header');

toggleButton.addEventListener('click', () => {
    header.classList.toggle('open');
});
