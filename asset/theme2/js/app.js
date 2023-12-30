'use strict';

$( document ).ready(function() {
  //preloader
  $(".preloader-holder").delay(300).animate({
    "opacity" : "0"
    }, 300, function() {
    $(".preloader-holder").css("display","none");
  });

  $(".country-select-part").on('click', function(){
    $(this).toggleClass('active')
  });

});

$(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function() {
  const element = $(this).parent("li");
  if (element.hasClass("open")) {
    element.removeClass("open");
    element.find("li").removeClass("open");
  }
  else {
    element.addClass("open");
    element.siblings("li").removeClass("open");
    element.siblings("li").find("li").removeClass("open");
  }
});

// menu options custom affix 
var fixed_top = $(".header");
$(window).on("scroll", function(){
    if( $(window).scrollTop() > 50){  
      fixed_top.addClass("animated fadeInDown header-fixed");
    }
    else {
      fixed_top.removeClass("animated fadeInDown header-fixed");
    }
});

// mobile menu js
$(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function() {
  const element = $(this).parent("li");
  if (element.hasClass("open")) {
    element.removeClass("open");
    element.find("li").removeClass("open");
  }
  else {
    element.addClass("open");
    element.siblings("li").removeClass("open");
    element.siblings("li").find("li").removeClass("open");
  }
});

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});

// Show or hide the sticky footer button
$(window).on("scroll", function() {
	if ($(this).scrollTop() > 200) {
			$(".back-to-top").fadeIn(200);
	} else {
			$(".back-to-top").fadeOut(200);
	}
});

// Animate the scroll to top
$(".back-to-top").on("click", function(event) {
	event.preventDefault();
	$("html, body").animate({scrollTop: 0}, 300);
});

// lightcase plugin init
$('a[data-rel^=lightcase]').lightcase();

new WOW().init();

// faq js
$('.faq-single-header').each(function(){
  $(this).on('click', function(){
    $(this).siblings('.faq-single-body').slideToggle();
    $(this).parent('.faq-single').toggleClass('active');
  });
});

// testimonial-slider
$('.testimonial-slider').slick({
  infinite: true,
  slidesToShow: 3,
  slidesToScroll: 1,
  dots: false,
  arrows: true,
  prevArrow: $('.prev-btn'),
  nextArrow: $('.next-btn'),
  autoplay: false,
  cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
  speed: 1500,
  autoplaySpeed: 500,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 2,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 2,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
      }
    }
  ]
});


// brand-slider
$('.brand-slider').slick({
  infinite: true,
  slidesToShow: 6,
  slidesToScroll: 1,
  dots: false,
  arrows: false,
  autoplay: false,
  cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
  speed: 1500,
  autoplaySpeed: 500,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 5,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 4,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
      }
    }
  ]
});


var currencyField = $('#currencyOne');
var currencyImg = $('#custom-currency-btn img');
var currencyText = $('#custom-currency-value');
var currencyListItem = $('#custom-currency-list li');

$(currencyListItem).each(function(){
  var currencyListImg = $(this).children('img').attr('src');
  var currencyListText = $(this).children('span').data('currency');

  $(this).on('click', function(){
    $(currencyField).val(currencyListText);
    $(currencyImg).attr('src', currencyListImg);
    $(currencyText).text(currencyListText);

    $('#custom-currency-options').removeClass('active');
  });
});

$('#custom-currency-btn').on('click', function(){
  $('#custom-currency-options').addClass('active');
})


var currencyFieldTwo = $('#currencyTwo');
var currencyImgTwo = $('#custom-currency-btn-two img');
var currencyTextTwo = $('#custom-currency-value-two');
var currencyListItemTwo = $('#custom-currency-list-two li');

$(currencyListItemTwo).each(function(){
  var currencyListImg = $(this).children('img').attr('src');
  var currencyListText = $(this).children('span').data('currency');

  $(this).on('click', function(){
    $(currencyFieldTwo).val(currencyListText);
    $(currencyImgTwo).attr('src', currencyListImg);
    $(currencyTextTwo).text(currencyListText);

    $('#custom-currency-options-two').removeClass('active');
  });
});

$('#custom-currency-btn-two').on('click', function(){
  $('#custom-currency-options-two').addClass('active');
})


$(document).ready(function(){
  $("#currency-search-field").keyup(function(){
    var filter = $(this).val(), count = 0;
    $("#custom-currency-list li").each(function(){
      if ($(this).attr('data-currency').search(new RegExp(filter, "i")) < 0) {
        $(this).fadeOut();
      } else {
        $(this).show();
        count++;
      }
    });
  });

  $("#currency-search-field-two").keyup(function(){
    var filter = $(this).val(), count = 0;
    $("#custom-currency-list-two li").each(function(){
      if ($(this).attr('data-currency').search(new RegExp(filter, "i")) < 0) {
        $(this).fadeOut();
      } else {
        $(this).show();
        count++;
      }
    });
  });
});