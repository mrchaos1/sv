$('.js-book-button').click(function()
{
    var button      = $(this);
    var book_form   = $('form#js-book-form');

    var date_from_selector   = button.attr('data-date-from-selector');
    var date_to_selector     = button.attr('data-date-to-selector');
    var room_selector        = button.attr('data-room-selector');
    var room_id              = button.attr('data-room-id');

    if(book_form.length > 0)
    {
        if(date_from_selector && date_from_selector != undefined && date_from_selector != '')
        {
            book_form.find('input.js-date-from').val($(date_from_selector).val());
        }

        if(date_to_selector && date_to_selector != undefined && date_to_selector != '')
        {
            book_form.find('input.js-date-to').val($(date_to_selector).val());
        }

        if(room_selector && room_selector != undefined && room_selector != '')
        {
            book_form.find('select.js-room').val($(room_selector).val());
        }

        if(room_id && room_id > 0)
        {
            book_form.find('select.js-room').val(room_id);
        }
    }

});


$('.flash-message').click(function(){ $(this).hide(200); })
