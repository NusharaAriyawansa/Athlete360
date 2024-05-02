const navbar = document.querySelector('.navbar-links')
const menuBtn = document.querySelector('.menu-btn')
const closeBtn = document.querySelector('.close-btn')
const header = document.querySelector('.header')
const servicesSection = document.querySelector('.services-section')
const heroSection = document.querySelector('.hero-section')
const main = document.querySelector('main')
// handling menu opening on mobile phones
menuBtn.addEventListener( 'click', () => {
    navbar.classList.add('active');
    menuBtn.classList.add('remove')
    closeBtn.classList.add('active')
})

closeBtn.addEventListener( 'click', () => {
    navbar.classList.remove('active');
    menuBtn.classList.remove('remove')
    closeBtn.classList.remove('active')
})

let headerHeight = header.getBoundingClientRect().height
let options = {
    root: null,
    rootMargin: `-${headerHeight}px`,
    threshold: 0.15,
  };
  
let observer = new IntersectionObserver((e)=> {
    const [entry] = e
    if(entry.isIntersecting) {
        header.classList.add('fixed')
        main.style.paddingTop = '4rem'
    }
}, options);

observer.observe(servicesSection);

let headerObserver = new IntersectionObserver((e) => {
    const [entry] = e
    if(entry.isIntersecting) {
        header.classList.remove('fixed')
        main.style.paddingTop = '0rem';
    }
}, {
    root: null,
    threshold: 0.8,
    rootMargin: '0px',
})

headerObserver.observe(heroSection)