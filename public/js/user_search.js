$(function () {
  $('.accordion-search').on("click",function () {
    $(".search_conditions_inner").slideToggle();
    $(".accordion-search").toggleClass("open");
  });

  $('.accordion-edit').click(function () {
    $(".accordion-edit").toggleClass("open");
    $('.subject_inner').slideToggle();
    $('.edit-btn').slideToggle();
  });
  $(".subject_edit_btn").click(function(){
    $(".accordion-edit").toggleClass("open");
    $('.subject_inner').slideToggle();
    $('.edit-btn').slideToggle();
  })
});
$(".subcategories").hide();
$(function () {
  $(".js-accordion").on("click", function () {
    $(this).next().slideToggle();
    $(this).toggleClass("open");
  });
});
$(function () {
  $('.search_conditions').on("click",function () {
    $(".search_conditions_inner").slideToggle();
    $(".accordion-search").toggleClass("open");
  })});