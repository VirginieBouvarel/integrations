"use strict";

const keys = document.querySelector('.key-points');
const partners = document.querySelector('.partners');

window.addEventListener('scroll', () => {
    animateOnScroll(keys);
    animateOnScroll(partners);
});

function animateOnScroll(target) {
    if(window.scrollY >= target.offsetTop - 1000) {
        target.classList.add('animated');
    } 
    
    
}


   
