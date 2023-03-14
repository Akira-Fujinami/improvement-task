// $(function() {
//     alert('OK!');
//   });
$(function(){
    $('.reserve-modal-open').on('click',function(){
    $(".js-modals").fadeIn();
    var reserve_date = $(this).attr('reserve_date');
    var reserve_part = $(this).attr('reserve_part');
    var reserve_id = $(this).attr('reserve_id');
    $('.modal_reserve').val(reserve_date);
    $('.modal_part').val(reserve_part);
    $('.modal_id').val(reserve_id);
    return false;
});
$('.js-modal-close').on('click',function(){
    $(".js-modals").fadeOut();
    return false;
})
})