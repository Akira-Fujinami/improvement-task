$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
  });

  $('.subject_edit_btn').click(function () {
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