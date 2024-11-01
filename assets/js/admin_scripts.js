(function ($) {

    $(document).ready(function () {
        const repeater = $('.repeater').repeater({
            // (Optional)
            // start with an empty list of repeaters. Set your first (and only)
            // "data-repeater-item" with style="display:none;" and pass the
            // following configuration flag
            initEmpty: false,

            show: function () {
                const limitCount = 10;
                const itemsCount = parseInt( $(this).parents(".repeater").find("div[data-repeater-item]").length );

                if (limitCount) {
                    if (itemsCount <= limitCount) {
                        $(this).slideDown();

                        $('select.select2').select2();
                        $('select.select2_multiple').select2({
                            closeOnSelect: false
                        });
                    }
                    else {
                        $(this).remove();
                    }
                }
                else {
                    $(this).slideDown();

                    $('select.select2').select2();
                    $('select.select2_multiple').select2({
                        closeOnSelect: false
                    });
                }

                const row = $(this);
                const rowIndex = itemsCount - 1

                const firstMatch = row.find( `input[name="wp_linker[${rowIndex}][numberOfFirstMatch]"]` )
                if( firstMatch.length > 0 ){
                    firstMatch[0].value = 1;
                }

                const maxMatches = row.find( `input[name="wp_linker[${rowIndex}][numberOfMaxMatches]"]` )
                if( maxMatches.length > 0 ){
                    maxMatches[0].value = 10;
                }

                const skips = row.find( `input[name="wp_linker[${rowIndex}][numberOfSkips]"]` )
                if( skips.length > 0 ){
                    skips[0].value = 2;
                }


                if (itemsCount >= limitCount) {
                    $(".repeater input[data-repeater-create]").hide();
                }
            },
            // (Optional)
            // "hide" is called when a user clicks on a data-repeater-delete
            // element.  The item is still visible.  "hide" is passed a function
            // as its first argument which will properly remove the item.
            // "hide" allows for a confirmation step, to send a delete request
            // to the server, etc.  If a hide callback is not given the item
            // will be deleted.
            hide: function (deleteElement) {
                const limitCount = 10;
                const itemsCount = $(this).parents(".repeater").find("div[data-repeater-item]").length;

                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }

                if (itemsCount <= limitCount) {
                    $(".repeater input[data-repeater-create]").show();
                }
            },
            // (Optional)
            // You can use this if you need to manually re-index the list
            // for example if you are using a drag and drop library to reorder
            // list items.
            // ready: function (setIndexes) {
            //     $dragAndDrop.on('drop', setIndexes);
            // },
            // (Optional)
            // Removes the delete button from the first list item,
            // defaults to false.
            isFirstItemUndeletable: true
        })

        $('select.select2').select2();
        $('select.select2_multiple').select2({
            closeOnSelect: false
        });

    });

    $(document).on('click', '.modalTrigger', function (event) {
        event.preventDefault();

        var config = $(this)[0].offsetParent.nextElementSibling.nextElementSibling;
        $(this).toggleClass('clicked');
        config.classList.toggle('show');
    });



})(jQuery);
