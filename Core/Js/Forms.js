/**
 * Created by Dominic on 15/11/2015.
 */


$( document ).ready(function() {
    var formsBaseURL="/Core/Forms/";

    var forms ={
      test:"form.php",
      addsubboard:"addsubboard.php"
    };

    var formOpen = false;
    var openForm = null;

    $("a[data-form-link]").click(function(){
        var formToLoad=$(this).attr('data-form-link');
        var data = $(this).attr('data-form-data');

        if(in_array(formToLoad, forms)) {
            if(formOpen){
                destroyFormDiv();
                formOpen = false;
            }else {
                formOpen = true;
                createFormDiv(formsBaseURL + forms[formToLoad], data);
            }
        }
    });

    function createFormDiv(formURL, data){
        div = $('<div />', {'class':'jqueryForm'});
        div.load(formURL+"?form-data="+data, function(){

            openForm = div;
            $("body").append(openForm);
            adjustPopUp();
        });
    }

    function destroyFormDiv(){
        openForm.remove();
    }

    function adjustPopUp(){
        var div = $(".jqueryForm");

        div.css("margin-left", -(div.width() / 2));
        div.css("margin-top", -(div.height() / 2));
    }

});