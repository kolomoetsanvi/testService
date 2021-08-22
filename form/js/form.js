$(function () {

    const helpBlockInput = $("#help-block-input");
    const helpBlockPrice = $("#help-block-price");
    const helpBlockDate = $("#help-block-date");

    $("#products-form").on('click', '#btn-add', function (e) {
        e.preventDefault();
        let form = $("#product-form").serializeArray();
        $.ajax({
            type: 'post',
            url: 'http://api/product',
            data: form,
            success: function (data) {
                if(data.status === "true"){
                    $("#name-input").val('');
                    $("#price-input").val('');
                    $("#date-input").val('');
                    getProductTable();
                } else {
                    if ("errors" in data){
                        setErrorsMes(data.errors);
                    }
                }
            },
            error: function (data) {
                console.error('Ошибка передачи данных!')
            }

        });
        return false;
    })

    function getProductTable() {
        $.ajax({
            type: 'get',
            url: 'http://api/product',
            success: function (data) {
                document.getElementById("products-table-body").innerHTML = getTableHtml(data);
            },
            error: function (data) {
                console.error('Ошибка передачи данных!')
            }
        });
        return false;
    }

    function getTableHtml(data){
        let rows = '';
        data.products.forEach(function(item) {
            rows +='<tr>' + '<td class="first-column">' + item.name +
                '</td>' +  '<td>' + item.price + '</td>' +
                '<td>' + item.dateAndTime + '</td>' +
                '</tr>';
        });

         return rows;
    }

    $(document).on('keydown', '#price-input', function(e){
        var input = $(this);
        var oldVal = input.val();
        var regex = new RegExp(input.attr('pattern'), 'g');

        setTimeout(function(){
            var newVal = input.val();
            if(!regex.test(newVal)){
                input.val(oldVal);
            }
        }, 0);
    });

    function  setErrorsMes(errors){
        if ("name-input" in errors){
            helpBlockInput.html(errors["name-input"]);
            helpBlockInput.closest(".form-group").addClass('has-error');
        }
        if ("price-input" in errors){
            helpBlockPrice.html(errors["price-input"]);
            helpBlockPrice.closest(".form-group").addClass('has-error');
        }
        if ("date-input" in errors){
            helpBlockDate.html(errors["date-input"]);
            helpBlockDate.closest(".form-group").addClass('has-error');
        }
        return true;
    }

    $(document).on('change', '#name-input', function () {
        helpBlockInput.html("")
        helpBlockInput.closest(".form-group").removeClass('has-error');
    })
    $(document).on('change', '#price-input', function () {
        helpBlockPrice.html("")
        helpBlockPrice.closest(".form-group").removeClass('has-error');
    })
    $(document).on('change', '#date-input', function () {
        helpBlockDate.html("")
        helpBlockDate.closest(".form-group").removeClass('has-error');
    })

    $(document).ready(function() {
        getProductTable();
    });
})