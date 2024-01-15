import $ from 'jquery';
var url = 'http://redsocial-laravel.com.devel';
window.addEventListener("load", function(){
    $('.btn-like').css('cursor', 'pointer');
     $('.btn-dislike').css('cursor', 'pointer');
    //button like
    function like() {
        $('.btn-like').unbind('click').click(function(){
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url+'/img/corazonrojo.png');
            //Peticion ajax
            $.ajax({
               url: url+'/like/'+$(this).data('id'),
               type: 'GET',
               headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               success: function(response) {
                   console.log('Respuesta exitosa:', response);

                    if (response.like) {
                        console.log('Has dado like');
                    } else if (response.message === 'Ya has dado like a esta publicación') {
                        console.log('Ya has dado like a esta publicación');
                    } else {
                        console.log('Error al dar like');
                    }
               },
               error: function(error) {
               console.log('Error en la petición Ajax:', error);
               }
            });
            dislike();
        })      
    }
    like();
    //button dislike
    function dislike() {
        $('.btn-dislike').unbind('click').click(function(){
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', url+'/img/corazongris.png');
            //Peticion ajax
            $.ajax({
               url: url+'/dislike/'+$(this).data('id'),
               type: 'GET',
               headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               success: function(response) {
                   console.log('Respuesta exitosa:', response);
                    if (response.message === 'Te ha dejado de gustar la publicación') {
                        console.log('Te ha dejado de gustar la publicación');
                    } else {
                        console.log('Error al dar dislike');
                    }
               },
               error: function(error) {
               console.log('Error en la petición Ajax:', error);
               }
            });
            like();
        })
    }
    dislike();
});
