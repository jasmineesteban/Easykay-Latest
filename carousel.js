$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
      loop:true,
      margin:10,
      nav:true,
      dots:true,
      autoplay:true, // Add autoplay option
      autoplayTimeout:3000, // Set autoplay timeout in milliseconds (3000ms = 3 seconds)
      responsive:{
          0:{
              items:1
          },
          600:{
              items:2
          },
          1000:{
              items:3
          }
      }
    })
});
