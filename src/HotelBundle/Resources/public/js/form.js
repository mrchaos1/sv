$('.js-book-button').click(function()
{
    var button      = $(this);
    var book_form   = $('form#js-book-form');

    var date_from_selector   = button.attr('data-date-from-selector');
    var date_to_selector     = button.attr('data-date-to-selector');
    var room_selector        = button.attr('data-room-selector');

    var room_id             = button.attr('data-room-id');

//    alert(date_from_selector + ', ' + date_to_selector + ', ' + room_selector  + ', ' + room_id);

    if(book_form.length > 0)
    {
        if(date_from_selector && date_from_selector != undefined && date_from_selector != '')
        {
            book_form.find('input.js-date-from').val($(date_from_selector).val());
        }

    }

});


$('.flash-message').click(function(){ $(this).hide(200); })
