<!DOCTYPE html>
<html>
    <head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    </head>
    <body >
        <textarea type="text" id="fc" rows="8" style="width:100%"></textarea>
        <button type="button" id="eksekusi">Eksekusi</button>
        <hr/>
        <h3>Result :<h3> 
        <textarea id="result" rows="8" style="width:100%">
            
        </textarea>
    </body>
    <script>
        $( "#eksekusi" ).on( "click", function( event ) {
            var f = $("#fc").val();
          $.post( "{{ url('') }}"+"/api/response_fnc", { func : f})
          .done(function( data ) {
            console.log(data)
            $("#result").val(JSON.stringify(data))
          });
        });
    </script>
</html>
