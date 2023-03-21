$(function () {
  $('.accordion-search').on("click",function () {
    $(".search_conditions_inner").slideToggle();
    $(".accordion-search").toggleClass("open");
  });

  $('.accordion-edit').click(function () {
    $(".accordion-edit").toggleClass("open");
    $('.subject_inner').slideToggle();
  });
});
$(".subcategories").hide();
$(function () {
  $(".js-accordion").on("click", function () {
    $(this).next().slideToggle();
    $(this).toggleClass("open");
  });
});