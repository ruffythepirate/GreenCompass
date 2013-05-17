<script type="text/javascript">
    $(document).ready( function() {
           
        $('#Button_CreateNew').click( function() {            
            loadPopupBox();
        });

        $('#CloseAddLanguage').click( function() {            
            unloadPopupBox();
        });
        
        $('#AddLanguage').click( function() {
            //We Add a form to the page.
            
            var languageId = $('#NewLanguageSelect').val();
             $.ajax({
                type: "GET",
                url: "ajax_new_language.php",
                data: {languageid: languageId }
                })
                .done(
                function( result ) {
                    $("#WorkshopForms").append( result );
                });            
        });

        function unloadPopupBox() {    // TO Unload the Popupbox
            $('#newtranslationpopup').fadeOut("slow");
            $("#container").css({ // this is just for style        
                "opacity": "1"  
            }); 
        }    
        
        function loadPopupBox() {    // To Load the Popupbox
            $('#newtranslationpopup').fadeIn("slow");
            $("#container").css({ // this is just for style
                "opacity": "0.3"  
            });         
        }        
    });
</script>   
