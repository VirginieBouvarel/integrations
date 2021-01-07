"use strict";

const keys = document.querySelector('.key-points');

window.addEventListener('scroll', () => {
    animateOnScroll(keys);
});

function animateOnScroll(target) {
    if(window.scrollY >= target.offsetTop - 600) {
        target.classList.add('animated');
    } 
    
    
}


   
