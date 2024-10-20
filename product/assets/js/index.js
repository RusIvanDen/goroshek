$(document).ready(function () {
    $('.header__burger').click(function (event) {
        $('.header__burger,.header__menu').toggleClass('active');
        $('body').toggleClass('lock')
    });
});
let swiper = new Swiper(".mySwiper", {
    effect: "cube",
    grabCursor: true,
    loop: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    cubeEffect: {
        shadow: false,
        slideShadows: false,
        shadowOffset: 1,
        shadowScale: 0.94,
    },
});


function log1() {
    let l1 = document.querySelector(".log__login");
    l1.classList.toggle("log__input_text");
}
function log2() {
    let l2 = document.querySelector(".log__password");
    l2.classList.toggle("log__input_text");
}
function reg1() {
    let r1 = document.querySelector(".reg__name");
    r1.classList.toggle("reg__input_text");
}
function reg2() {
    let r2 = document.querySelector(".reg__surname");
    r2.classList.toggle("reg__input_text");
}
function reg3() {
    let r3 = document.querySelector(".reg__patronymic");
    r3.classList.toggle("reg__input_text");
}
function reg4() {
    let r4 = document.querySelector(".reg__login");
    r4.classList.toggle("reg__input_text");
}
function reg5() {
    let r5 = document.querySelector(".reg__email");
    r5.classList.toggle("reg__input_text");
}
function reg6() {
    let r6 = document.querySelector(".reg__password");
    r6.classList.toggle("reg__input_text");
}
function reg7() {
    let r7 = document.querySelector(".reg__password2");
    r7.classList.toggle("reg__input_text");
}

function reg8() {
    let r8 = document.querySelector(".reg__phone");
    r8.classList.toggle("reg__input_text");
}
