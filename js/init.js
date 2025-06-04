$ = jQuery;
$(document).ready(function () {
    "use strict";


    // $('body:not( .woocommerce )select').selectric({
    //     disableOnMobile: false
    // });
    // $('.datepicker').pickadate();
    AOS.init({
        offset: 0,
        duration: 350,
        easing: 'ease-in-out-quart',
        delay: 0,
        once: true,
        disable: 'mobile',
        anchor: 'top-bottom'
    });


});
/* end ready*/
$(window).on('load', function () {


    var swiper_example = new Swiper('.news-blocks .swiper', {
        speed: 1000,
        slidesPerView: "auto",
        spaceBetween: 30,
        // autoHeight: true, 
        navigation: {
            nextEl: '.news-blocks .swiper-button-next',
            prevEl: '.news-blocks .swiper-button-prev',
        },
        breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 20
        },
        767: {
          slidesPerView: "auto",
          spaceBetween: 20
        },
      }
    });

    var swiper_example2 = new Swiper('.members-slider .swiper', {
        speed: 1000,
        slidesPerView: 1,
        spaceBetween: 25,
        autoplay: {
          delay: 5000,
        },
        breakpoints: {
        1366: {
          slidesPerView: 5,
        },
        1024: {
          slidesPerView: 4,
        },
        768: {
          slidesPerView: 3,
        },
        480: {
          slidesPerView: 2,
        },
      }
    });

    var swiper = new Swiper(".events-slider-wrap .swiper", {
      slidesPerView: 3,
      grid: {
        rows: 2,
      },
      spaceBetween: 30,
      pagination: {
        el: ".events-slider-wrap .swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          grid: {
            rows: 1,
          },
        },
      767: {
          slidesPerView: 3,
          grid: {
            rows: 2,
          },
        },
      }

    });

    Fancybox.bind("[data-fancybox]", {
      // Your custom options
    });




});