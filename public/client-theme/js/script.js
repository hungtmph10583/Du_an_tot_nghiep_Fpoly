/*=============== SHOW MODAL ===============*/
// const showModal = (openButton, modalContent) => {
//     const openBtn = document.getElementById(openButton),
//         modalContainer = document.getElementById(modalContent)

//     if (openBtn && modalContainer) {
//         openBtn.addEventListener('click', () => {
//             modalContainer.classList.add('show-modal')
//         })
//     }
// }
// showModal('open-modal', 'modal-container')

// /*=============== CLOSE MODAL ===============*/
// const closeBtn = document.querySelectorAll('.close-modal')

// function closeModal() {
//     const modalContainer = document.getElementById('modal-container')
//     modalContainer.classList.remove('show-modal')
// }
// closeBtn.forEach(c => c.addEventListener('click', closeModal))

/**
 * @note: status active ( cart, menu)
 * hungtm
 * down
 */

let shoppingCart = document.querySelector('.shopping-cart');
let navbar = document.querySelector('.navbar');

var menu = document.getElementById('menu-btn');
var cart = document.getElementById('cart-btn');
document.addEventListener('click', function(event) {
    var isClickInsideMenu = menu.contains(event.target);
    var isClickInsideCart = cart.contains(event.target);

    if (isClickInsideMenu) {
        navbar.classList.toggle('active');
        shoppingCart.classList.remove('active');
    } else {
        navbar.classList.remove('active');
    }

    if (isClickInsideCart) {
        shoppingCart.classList.toggle('active');
        navbar.classList.remove('active');
    } else {
        shoppingCart.classList.remove('active');
    }
});

window.onscroll = () => {
    shoppingCart.classList.remove('active');
    navbar.classList.remove('active');
}

/**
 * @note: slider products
 * hungtm
 * down
 */
var swiper = new Swiper(".category-slide", {
    loop: true,
    spaceBetween: 20,
    autoplay: {
        delay: 7500,
        disableOnInteraction: false,
    },
    centeredSlides: true,
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1020: {
            slidesPerView: 3,
        },
    },
});
/**
 * @note: slider review
 * hungtm
 * down
 */
// var swiper = new Swiper(".member-container", {
//     loop: true,
//     autoplay: {
//         delay: 7500,
//         disableOnInteraction: false,
//     },
//     centeredSlides: true,
//     breakpoints: {
//         0: {
//             slidesPerView: 1,
//         },
//         768: {
//             slidesPerView: 2,
//         },
//         1020: {
//             slidesPerView: 3,
//         },
//     },
// });
/**
 * @note: scroll to top
 * hungtm
 * down
 */

window.addEventListener("scroll", function() {
    var header = document.querySelector(".scrollToTop");
    header.classList.toggle("sticky", window.scrollY > 1000);
});

const scrollToTop = document.querySelector("#scrollToTop");
scrollToTop.addEventListener("click", function() {
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth"
    });
});

/**
 * @note: slider
 * hungtm
 * down
 */
var swiper = new Swiper(".slider-container", {
    // spaceBetween: 30,
    // centeredSlides: true,
    // autoplay: {
    //     delay: 7500,
    //     disableOnInteraction: false,
    // },
    // navigation: {
    //     nextEl: ".swiper-button-next",
    //     prevEl: ".swiper-button-prev",
    // },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },
    // loop: true,
    loop: true,
    spaceBetween: 30,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    speed: 450,
    autoplay: {
        delay: 7000,
    },
});
// let slides = document.querySelectorAll('.sliders .sliders-container .slide');
// let index = 0;

// function next() {
//     slides[index].classList.remove('active');
//     index = (index + 1) % slides.length;
//     slides[index].classList.add('active');
// }

// function prev() {
//     slides[index].classList.remove('active');
//     index = (index - 1 + slides.length) % slides.length;
//     slides[index].classList.add('active');
// }
// detail

function changeImage(id) {
    let imagePath = document.getElementById(id).getAttribute('src');
    console.log(imagePath);
    document.getElementById('img-main').setAttribute('src', imagePath);
}


function backQuantity() {
    var result = document.getElementById('quantity');
    var qty = result.value;
    if (qty > 1) result.value--;
    return false;
}

function nextQuantity() {
    var result = document.getElementById('quantity');

    var qty = result.value;
    if (!isNaN(qty)) result.value++;
    return false;
}