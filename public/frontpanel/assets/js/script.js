var $body = $('body'),
$overlay = $('.global-overlay');



/***** Toolbar Button Click Function *******/

$('.js-toolbar-btn').on('click', function (e) {
e.preventDefault();
e.stopPropagation();
var $this = $(this);
var target = $this.data('target');
$body.toggleClass('body-open');
$(target).toggleClass('open');
$($overlay).addClass('overlay-open');
$this.toggleClass('open');
});


/***** Document Click Function *******/

// $body.on('click', function (e) {
// var $target = e.target;
// var dom = $('.wrapper').children();

// if (!$($target).is('.js-toolbar-btn') && !$($target).parents().is('.open')) {
//     dom.removeClass('open');
//     $body.removeClass('body-open');
//     dom.find('.open').removeClass('open');
//     $overlay.removeClass('overlay-open');
// }

// });


/***** Close Button Click Function *******/

$('.btn-close').on('click', function (e) {
e.preventDefault();
var $this = $(this);
$this.parents('.open').removeClass('open');
$($overlay).removeClass('overlay-open');
});


// STICKY HEADER & MENU

// Hide header on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('.nav_header').outerHeight();

$(window).scroll(function (event) {
  didScroll = true;
});

setInterval(function () {
  if (didScroll) {
    hasScrolled();
    didScroll = false;
  }
}, 250);

function hasScrolled() {
  var st = $(this).scrollTop();

  // Make scroll more than delta
  if (Math.abs(lastScrollTop - st) <= delta)
    return;

  // If scrolled down and past the navbar, add class .nav-up.
  if (st > lastScrollTop && st > navbarHeight) {
    // Scroll Down
    $('.nav_header').removeClass('nav-down').addClass('nav-up');
  } else {
    // Scroll Up
    if (st + $(window).height() < $(document).height()) {
      $('.nav_header').removeClass('nav-up').addClass('nav-down');
    }
  }

  lastScrollTop = st;
}









    // document.addEventListener('DOMContentLoaded', function () {
    //     var menuItems = document.querySelectorAll('.mainmenu_item');
        
    //     menuItems.forEach(function(item) {
    //         item.addEventListener('click', function() {
    //             var dropdown = this.querySelector('.dropdown');
    //             if (dropdown) {
    //                 dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    //             }
    //         });
    //     });
    // });
    
// Testimonials
var swiper = new Swiper(".testi_swiper", {
    autoHeight: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
  });

    // Training 
    var mySwiper = new Swiper('.tr_swiper', {
        loop: true,
        speed: 1000,
        // autoplay: {
        //     delay: 3000,
        // },
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        coverflowEffect: {
            rotate: 30,
            stretch: 0,
            depth: 150,
            modifier: 1,
            slideShadows: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
    
    })


    // Landing Page ANIMATION 

    window.addEventListener('load', () => {
        const icons = document.querySelectorAll('.lan_icons');
        const mainBanner = document.querySelector('.landing_wrapper img');
        const textPrimary = document.querySelector('.overlay_details .text_primary');
        const heading = document.querySelector('.overlay_details h1');
        const button = document.querySelector('.sec_btn');

        // Apply animations to icons
        icons.forEach((icon, index) => {
            setTimeout(() => {
                icon.classList.add('fadeIn');
            }, index * 100); // Reduced stagger from 200ms to 100ms
        });

        // Apply animation to main banner image
        setTimeout(() => {
            mainBanner.classList.add('fadeIn');
            mainBanner.style.transform = 'scale(1)';
        }, 800);

        // Apply animations to text and button
        setTimeout(() => {
            textPrimary.classList.add('slideInLeft');
            textPrimary.style.opacity = '1';
            textPrimary.style.transform = 'translateY(0)';
        }, 1000);

        setTimeout(() => {
            heading.classList.add('slideInRight');
            heading.style.opacity = '1';
            heading.style.transform = 'translateY(0)';
        }, 1200);

        setTimeout(() => {
            button.classList.add('fadeIn');
            button.style.opacity = '1';
            button.style.transform = 'translateY(0)';
        }, 1400);
    });



    // Fancy 
    document.addEventListener("DOMContentLoaded", function() {
        Fancybox.bind("[data-fancybox='gallery']", {
            // Your custom options (if any)
        });
    });
    Fancybox.bind("[data-fancybox='gallery']", {
        Toolbar: {
            display: [
                { id: "counter", position: "center" },
                "zoom",
                "slideshow",
                "fullscreen",
                "thumbs",
                "close",
            ],
        },
        Thumbs: {
            autoStart: true,
        },
    });
    

    // Team clickable icons 
//     let menuToggle = document.querySelector('.menuToggle');
// menuToggle.onclick = function () {
//     menuToggle.classList.toggle('active');
// }

// SELECT 2 
$(document).ready(function() {
    $('.filter_vacant').select2();
});
$(document).ready(function() {
    $('.filter_vacant2').select2();
});


// Menu active state 
// Add this JavaScript to your script file or inline in your HTML

jQuery(function($) {
    var path = window.location.href; 
    // because the 'href' property of the DOM element is the absolute path
    $('ul a').each(function() {
      if (this.href === path) {
        $(this).addClass('page_active');
      }
    });
  });


  // AOS Animation 
  AOS.init();

  // latest demand swiper slider
  var swiper = new Swiper(".card_contaienr", {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    navigation: {
      nextEl: ".button-next",
      prevEl: ".button-prev",
    },
    breakpoints: {
      768: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      991: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
    },
  });
