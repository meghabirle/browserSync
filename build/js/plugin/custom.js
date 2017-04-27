// custom.js
 
 function change(id) {
    
    $('button').css('color','red');
       $.ajax({
       method:'POST',
       url: 'localhost/test/lorem',
       success: function() {
       console.log(' req has been done success')
      },
       error : function (error) {
       console.log(error) 
      }
     })
 }
