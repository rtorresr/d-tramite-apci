window.$ = window.jQuery = require('jquery');

require('materialize-css');

let SimpleBar = require('simplebar');
//let sal = require('sal.js')

import { library, dom, config } from '@fortawesome/fontawesome-svg-core';
import { fas, faWindowRestore } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';

library.add(fas, far, fab);
config.searchPseudoElements = true;
//console.log(config.searchPseudoElements);
// Replace any existing <i> tags with <svg> and set up a MutationObserver to
// continue doing this as the DOM changes.
dom.watch();

//require( 'jszip' );
const JSZip = require('jszip');
window.JSZip = JSZip;

import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";

pdfMake.vfs = pdfFonts.pdfMake.vfs;

require( 'datatables.net' )( window, $ );
require( 'datatables.net-autofill' )( window, $ );
require( 'datatables.net-buttons' )( window, $ );
require( 'datatables.net-buttons/js/buttons.colVis.js' )( window, $ );
require( 'datatables.net-buttons/js/buttons.flash.js' )( window, $ );
require( 'datatables.net-buttons/js/buttons.html5.js' )( window, $ );
require( 'datatables.net-buttons/js/buttons.print.js' )( window, $ );
require( 'datatables.net-colreorder' )( window, $ );
require( 'datatables.net-fixedcolumns' )( window, $ );
require( 'datatables.net-fixedheader' )( window, $ );
require( 'datatables.net-keytable' )( window, $ );
require( 'datatables.net-responsive' )( window, $ );
require( 'datatables.net-rowgroup' )( window, $ );
require( 'datatables.net-rowreorder' )( window, $ );
require( 'datatables.net-scroller' )( window, $ );
require( 'datatables.net-select' )( window, $ );
require( 'jquery-datatables-checkboxes' )( window, $ );
require( 'jquery-confirm' );

//import "jquery-validation/dist/jquery.validate";

require('select2')($);

require('chart.js');

//const Highcharts = require('highcharts');

// Load module after Highcharts is loaded
//require('highcharts/modules/no-data-to-display')(Highcharts);

/*
$(document).ajaxStart(function () {
  getSpinner();
}).ajaxStop(function () {
  setTimeout(function () {
    deleteSpinner();
  }, 100);
});
*/

$(function(){
  //M.AutoInit();
  $('.js-example-basic-single').select2();
  $('.sidenav').sidenav();

  if ( $( "#slide-out" ).length ) {
    new SimpleBar(document.getElementById('slide-out'), {
      scrollbarMinSize: 100,
    });
  }

  $('.profile-trigger').dropdown({
    inDuration: 300,
    outDuration: 225,
    hover: false, // Activate on hover
    coverTrigger: false, // Displays dropdown below the button
    alignment: 'top' // Displays dropdown with edge aligned to the left of button
  });
  //$('.profile-trigger').dropdown();
  $('.tabs').tabs();
  $('.collapsible').collapsible();
  $('.tooltipped').tooltip();
  $('.datagrid').DataTable({
    responsive: true,
    "language": {
      "url": "dist/scripts/datatables-es_ES.json"
    },
  });

var mqls = [ // list of window.matchMedia() queries
  window.matchMedia("(max-width: 575.98px)"),
  window.matchMedia("(max-width: 767.98px)"),
  window.matchMedia("(max-width: 991.98px)"),
  window.matchMedia("(max-width: 1199.98px)"),
  window.matchMedia("(min-width: 1200px)")
]

function mediaqueryresponse(mql){
  if (mqls[0].matches){}

  if (mqls[1].matches){}

  if (mqls[2].matches){}

  if (mqls[3].matches){}

  if (mqls[4].matches){}
}

for (var i=0; i<mqls.length; i++){
  mediaqueryresponse(mqls[i]) // call listener function explicitly at run time
  mqls[i].addListener(mediaqueryresponse) // attach listener function to listen in on state changes
}

$('#toggleEye').click(function(e){
  e.preventDefault();
  togglePassword("contrasena");
});

$('.sidenav-trigger').click(function() {
  $('body').toggleClass('sidebar-expand sidebar-collapse');
});

if($('li.bold').find('ul li.active').length !== 0){
  $('ul li.active').closest('.bold').addClass('active');
  $('ul li.active').closest('.collapsible-body').css('display', 'block');
}

$(document).on('click', '#toggleEye', function(){
  $('#toggleEye')
    .find('[data-fa-i2svg]')
    .toggleClass('fa-eye')
    .toggleClass('fa-eye-slash');
  });
});

$(document).ajaxStart(function () {
  getSpinner();
}).ajaxStop(function () {
    deleteSpinner();
});

window.togglePassword = function (input) {
  var x = document.getElementById(input);
  if (x.type === "password") {
      x.type = "text";
  } else {
      x.type = "password";
  }
}

window.getSpinner = function(message = 'Cargando...'){
  $("body").addClass("with-spinner");
  if($(".spinner").length) {
    $("#spinnerMessage").html(message);
  } else {
    $("body").append('<aside class="spinner"><i class="fas fa-circle-notch fa-spin"></i><span id="spinnerMessage">' + message + '<span></aside>').hide().fadeIn(300);
  }
};

window.getSpinnerSm = function (container) {
  var loader = `<div class="preloader-wrapper small active">
                  <div class="spinner-layer spinner-yellow-only">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div><div class="gap-patch">
                      <div class="circle"></div>
                    </div><div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
                </div>`;     
  $(container).append(loader);
}

window.deleteSpinnerSm = function(container){
  $(container + " .preloader-wrapper").fadeOut(300, function() {
    $(this).remove();
  });
};

window.deleteSpinner = function(){
  $("aside.spinner").fadeOut(300, function() {
    $(this).remove();
  });
  $("body").removeClass("with-spinner");
};

window.isIOs = function () {
  return [
    'iPad Simulator',
    'iPhone Simulator',
    'iPod Simulator',
    'iPad',
    'iPhone',
    'iPod'
  ].includes(navigator.platform)
  // iPad on iOS 13 detection
  || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
}
  
window.getPreIframe = function() {
  if (isIOs()) {
    // $("body").removeClass("not-ios");
    // $("body").addClass("is-ios");

    return 'https://drive.google.com/viewerng/viewer?embedded=true&url=';
  } else {
    // $("body").removeClass("is-ios");
    // $("body").addClass("not-ios");

    return '';
  }
}