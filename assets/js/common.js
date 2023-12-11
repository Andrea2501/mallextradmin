$(function () {
    
    $(document).on("click", "#btnlogout-agente", function (event) {
        event.preventDefault();
        $.ajax({
            url: "/infoagente/logoutagente",
            type: "POST",
            data: {
              value: 'agente',
            },
            success: function (response) {
              location.href='/';
              
            },
            error: function (xhr, textStatus, errorThrown) {
              // Gestisci eventuali errori
              console.log("Errore nella chiamata AJAX:", errorThrown);
            },
          });

    })
    function clearPasswordAgent(){
        $("#agente_password").val('');
    }

    
    

});