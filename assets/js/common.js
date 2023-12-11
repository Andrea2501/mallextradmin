$(function () {
    
    $(document).on("click", "#logout_impersonate_user", function (event) {
        event.preventDefault();
        var idUser = $(this).attr('data-impersonate-id');
        alert(idUser);

    })

    
    

});