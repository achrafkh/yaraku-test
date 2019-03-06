var table;
$(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
	table = $('#booksTable').DataTable({
    	responsive: true,
        "initComplete": function(settings, json) {
            $('#cardParent').removeClass('active');
        },
        order: [[ 1, "desc" ]],
        processing: true,
        info: true,
        stateSave: false,
        bProcessing: true,
        serverSide: true,
        ajax: {
            url: endpoint,
            type: "GET",
        },
        columns: getColumns(),
    });
});

// ------------------------------------------------------------------------------------ //

$(document).on('click','.delete-trigger',function(e){
    e.preventDefault();
    $('#cardParent').addClass('active');
    deleteBook($(this).data('id')).then(function(){
        table.ajax.reload();
        $('#cardParent').removeClass('active');
    })
});

$(document).on('click','.edit-trigger',function(e){
    e.preventDefault();
    $('#FormModalLabel').text('Edit Book : ' + $(this).data('title'));
    $('#title').val($(this).data('title'));
    $('#author').val($(this).data('author'));
    $('#id').val($(this).data('id'));

    $('#FormModal').modal();
});


$('#addBook').click(function(e){
    e.preventDefault();
    removeAlerts();
    $('#FormModalLabel').text('Add new Book');
    $('#title').val('');
    $('#author').val('');
    $('#id').val('');

    $('#FormModal').modal();
});


$('#form').submit(function(e){
    e.preventDefault();
    var id = $('#id').val();
    var method = (id == '') ? 'POST' : 'PUT';

    $('#cardParent').addClass('active');
    $(this).find(':submit').addClass('btn-loading').attr('disabled',true);
    removeAlerts();

    executeCall($(this).serializeArray(),method,id).then(function(){
        table.ajax.reload();
        $('#form').find(':submit').removeClass('btn-loading').attr('disabled',false);
        $('#FormModal').modal('hide');
        $('#cardParent').removeClass('active');

    });
});

$('#exportForm').submit(function(e){
    e.preventDefault();
    $('#cardParent').addClass('active');
    removeAlerts();


    $(this).find(':submit').addClass('btn-loading').attr('disabled',true);

    let type = $(this).find('input[name=type]:checked').val();
    let link = "books/export/"+type+"?" + $.param(table.ajax.params()) +'&'+ $(this).serialize();


    $.get(link).then(function(response){
        $('#exportForm').find(':submit').removeClass('btn-loading').attr('disabled',false);
        $('#cardParent').removeClass('active');

        // no errors
        if(response.length == 0){
             // this is in helper.js, it basicly appends an a
            downloadURI(link);
            $(this).parents('.modal').modal('hide');
        } else {
        // not the best code but it's just for rendering the errors
        let str = '';
        $.each(response,function(i,v){
            str += '- '+v+'\n\r\n\r';
        });
         sweetAlert({"title":"Wrong input!", "text":str,"type":"warning",'icon':"warning"});
         return false;
        }
    });
});




// ------------------------------------------------------------------------------------ //

function getColumns() {
    var cols = [];

    columns.forEach(function(v){
        cols.push({
            "orderable": true,
            "className": v,
            "searchable": true,
            'data': v
        });
    });

    cols.push({
        "orderable": false,
        "className": 'actions',
        "searchable": false,
        'data': 'id',
        "render": function ( data, type, row, meta ) {
           let string = '<div class="item-action dropdown">\
           <a href="javascript:void(0)" data-toggle="dropdown" class="icon" aria-expanded="false">\
           <i class="fe fe-more-vertical"></i></a><div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">';

            string += '<a href="#" data-id="'+data+'" data-title="'+row.title+'" data-author="'+row.author+'" class="dropdown-item edit-trigger"><i style="font-size: 15px;" class="dropdown-icon fa fa-pencil"></i> Edit</a>';
            string += '<a href="#" data-id="'+data+'" class="dropdown-item delete-trigger"><i style="font-size: 15px;" class="dropdown-icon fa fa-trash"></i> Delete</a>';
            string += '</div></div>';
    
            return string;
        }
    });
    return cols;
}


function deleteBook(id)
{
    return $.ajax({
            url: endpoint+'/'+id,
            type: 'DELETE',
            success: function(result) {
               sweetAlert("Done!", "Book deleted!", "success");
            },
            error: function(resp){
                sweetAlert("Oops!", "Something went wrong!", "error");
            }
        });
}

function executeCall(data,method,append)
{
    var url = endpoint

    if(append != null && append != ''){
        url += '/'+append;
    }
    return $.ajax({
            url: url,
            type: method,
            data: data,
            statusCode: {
                422: function(response) {
                    $.each(response.responseJSON.errors,function(i,v){
                        let input = $( "input[name='"+i+"']" );
                        input.after('<p class="help-block invalid-feedback feedback-output">'+v+'</p>');
                        input.addClass('is-invalid');
                    });
                    disableLoading();
                },
                404: function (response) {
                    sweetAlert("Oops!", "Not found!", "success");
                    disableLoading();

                },
                500: function (response) {
                    sweetAlert("Oops!", "Somethign went wrong!", "success");
                    disableLoading();
                }
            },
            success: function(result) {
               sweetAlert("Done!", "Book "+ (method == 'PUT' ? 'Updated!' : 'Created!') , "success");
            },
            always : function(){
                $('#title').val('');
                $('#author').val('');
                $('#id').val('');
            }
        });
}


function disableLoading()
{
    $('#cardParent').removeClass('active');
    $('#form').find(':submit').removeClass('btn-loading').attr('disabled',false);
}


function removeAlerts()
{
    $('.feedback-output').remove();
    $('.is-invalid').removeClass('is-invalid');
}