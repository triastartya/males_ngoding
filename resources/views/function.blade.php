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
        <hr/>
        <h3>Model :<h3> 
        <textarea id="model" rows="8" style="width:100%">
            
        </textarea>
    </body>
    <script>
        $( "#eksekusi" ).on( "click", function( event ) {
            var f = $("#fc").val();
            
            
            
          $.post( "{{ url('') }}"+"/api/response_fnc", { func : f})
          .done(function( data ) {
            console.log(data)
            $("#result").val(JSON.stringify(data))
            
            $.ajax({
                url: "https://json2csharp.com/api/Default",
                processData: false,
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                          "input": "[{\"id_jadwal_dokter\":40,\"id_dokter\":11,\"id_poli\":164,\"kuota\":5,\"hari\":1,\"jam_mulai\":\"09:00:00\",\"jam_selesai\":\"12:00:00\",\"keterangan\":\"TES\"}]",
                          "operationid": "jsontocsharp",
                          "settings": {
                            "UsePascalCase": "false",
                            "UseFields": "false",
                            "AlwaysUseNullables": "false",
                            "UseJsonAttributes": "false",
                            "NullValueHandlingIgnore": "false",
                            "UseJsonPropertyName": "false",
                            "ImmutableClasses": "false",
                            "RecordTypes": "false",
                            "NoSettersForCollections": "false"
                          }
                        }),
                dataType: 'json',
                cors: true ,
                secure: true,
                success: function(data){
                   $("#model").val(data)
                },
                error: function(){
                    app.log("Device control failed");
                }
            });
          });
        });
    </script>
</html>
