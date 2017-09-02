$(document).ready(function() {
  ReviewRating();
});

function ReviewRating () {
  $('.review-rating .star').mouseover(function() {
    $(this).prevAll().addClass('hover');
  }).mouseout(function() {
    $(this).prevAll().removeClass('hover');
  }).click(function() {
    $('.review-rating .star').removeClass('selected');
    $(this).addClass('selected');
    $(this).prevAll().addClass('selected');
    $(this).closest('form').find('[name=rating]').val(parseInt($(this).prevAll().length, 10) + 1);
  });
}