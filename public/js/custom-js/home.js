$(document).ready(function() {
      /******* navbar toggler btn ********/
   $(function () {
      'use strict';
      $('.toggle-btn').on('click', function () {
          $(this).toggleClass('transformed');
          $('.navbar-nav').addClass('collapsed-li');
      });
   });

   /***** init nice scroll ******/
   $(function() {
      $("body").niceScroll({
        scrollspeed: 80
      });
  });

   /******* to top btn Smooth scroll *********/

   $(".main-header .navbar-nav a[href^='#']").on('click', function(e) {
      e.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
         scrollTop: $(this.hash).offset().top
      }, 600);
   });

   $('#scroll-to-top-btn').on('click', function(){
      $('body,html').animate({
         scrollTop: 0
      }, 600);
   });



   // ------------------------------------------------------- //
   // back to top btn
   // ------------------------------------------------------ //
      window.onscroll = function() {scrollFunction()};
      function scrollFunction() {
      if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
         document.getElementById("scroll-to-top-btn").style.display = "block";
      } else {
         document.getElementById("scroll-to-top-btn").style.display = "none";
      }
   }
   $('#scroll-to-top-btn').each(function(){
      $(this).click(function(){
         $('html,body').animate({ scrollTop: 0 }, 1000);
         return false;
      });
   });

/*
   function ReadMoreFunction() {
      var more-options = document.getElementById("more-options-div");
      var more-less-btn = document.getElementById("more-less-btn");

      if (more-options.style.display === "none") {
            more-less-btn.innerHTML = "More Options";
      } else {
            more-less-btn.innerHTML = "Less Options";
      }
    }
*/
   // Check or Uncheck All checkboxes
   $("#checkall").change(function(){
      var checked = $(this).is(':checked');
      if(checked){
      $(".checkbox").each(function(){
         $(this).prop("checked",true);
      });
      }else{
      $(".checkbox").each(function(){
         $(this).prop("checked",false);
      });
      }
   });

   // Changing state of CheckAll checkbox 
   $(".checkbox").click(function(){
      if($(".checkbox").length == $(".checkbox:checked").length) {
         $("#checkall").prop("checked", true);
      } else {
         $("#checkall").removeAttr("checked");
      }

   });
      
});