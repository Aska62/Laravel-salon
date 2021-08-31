const hamburgerBox = document.querySelector('.hamburger-box');
const hamburgerTop = document.querySelector('.hamburger-top');
const hamburgerMiddle = document.querySelector('.hamburger-middle');
const hamburgerBottom = document.querySelector('.hamburger-bottom');
const menuBox = document.querySelector('.mob__menu-box');

hamburgerBox.addEventListener('click', ()=> {
    console.log('clicked!');
    if(hamburgerBox.classList.contains('box-cross')) {
        hamburgerBox.classList.remove('box-cross');
        hamburgerTop.classList.remove('top-open');
        hamburgerMiddle.classList.remove('middle-open');
        hamburgerBottom.classList.remove('bottom-open');
        menuBox.style.top ='9px';
    } else {
        hamburgerBox.classList.add('box-cross');
        hamburgerTop.classList.add('top-open');
        hamburgerMiddle.classList.add('middle-open');
        hamburgerBottom.classList.add('bottom-open');
        menuBox.style.top = '127px';
    }
})
