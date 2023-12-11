$(function () {
    var $body = $("body");
    var debounceTimer;
    
    $(document).on("keyup", "#tecno-txtCustomerSearch", function (event) {
      var val = $(this).val();
      clearTimeout(debounceTimer);
  
      if (val.length >= 3) {
        debounceTimer = setTimeout(function () {
          $.request('onAgentiCustomerSearch',{
            
            data: {
              value: val,
            },
            update:{
              '@items' :'#table-customers', 
              '@paginate': '#pga',
            },
            
          });
        }, 250);
      }
      else{
        debounceTimer = setTimeout(function () {
          $.request('onAgentiCustomerSearch',{
            
            data: {
              value: '',
            },
            update:{
              '@items' :'#table-customers', 
              '@paginate': '#pga',
            },
            
          });
        }, 250);
      } 
    });
    




  });