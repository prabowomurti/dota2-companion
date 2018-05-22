$(document).ready(function () {

    // override timeout value of pjax
    $.pjax.defaults.timeout = false;

    // ADD NEW junction row
    $('#add_new_junction_form').submit(function() {

        $.ajax({
            url : $(this).attr('data-url'),
            type : "POST",
            data : $(this).serialize(),
            error : function (xhr){
                alert('Error : ' + xhr.responseText);
            }
        }).done(function (data){
            $.pjax.reload({container: '#junction-list'});
            $('#add_new_junction_modal').modal('hide');
        });

        return false;
    });

    // EDIT junction
    var data_key;
    var params = 'id=';
    // edit button clicked
    $('.junction').on('click', '.junction-update', function () {
        // getting the clicked row values
        var row = $(this).parents('tr');
        data_key = row.attr('data-key');
        var parsed_key = $.parseJSON(data_key);
        if (typeof parsed_key === 'number')
            params = params + parsed_key; // return something like 'id=123';
        else 
            params = $.param(parsed_key);

        $('#edit_junction_form .modal-body .form-group .form-control').each(function (index) {
            // get the index, and then get the value from tr > td:eq()
            var td_index = $(this).attr('data-column-index');
            $(this).val($(row).children('td:eq(' + td_index + ')').text());

        });
    });

    var edit_junction_url = $('#edit_junction_form').attr('data-url') + '?';
    $('#edit_junction_form').submit(function() {
        $.ajax({
            url : edit_junction_url + params,
            type : "POST",
            data : $(this).serialize(),
            error : function (xhr){
                alert('Error : ' + xhr.responseText);
            }
        }).done(function (data){
            $.pjax.reload({container: '#junction-list'});
            $('#edit_junction_modal').modal('hide');
        });

        return false;
    });
});