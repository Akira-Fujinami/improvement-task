$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
  });

  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
  });
});
$(function () {
  // タイトルをクリックすると
  $(".accordion").on("click", function (e) {
    // タイトルにopenクラスを付け外しして矢印の向きを変更
    $(this).toggleClass("open");
    $('.subcategories').slideToggle('normal');
  });
});