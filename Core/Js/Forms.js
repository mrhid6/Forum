/**
 * Created by Dominic on 15/11/2015.
 */


$( document ).ready(function() {
    var formsBaseURL="Core/Forms/";

    var forms ={
      test:"form.php"
    };

    var formOpen = false;
    var openForm = null;

    $("a[data-form-link]").click(function(){
        var formToLoad=$(this).attr('data-form-link');
        if(in_array(formToLoad, forms)) {
            if(formOpen){
                destroyFormDiv();
                formOpen = false;
            }else {
                formOpen = true;
                createFormDiv(formsBaseURL + forms[formToLoad]);
            }
        }
    });

    function createFormDiv(formURL){
        div = $('<div />', {'class':'jqueryForm'});
        div.load(formURL);
        openForm = div;
        $("body").append(openForm);
    }

    function destroyFormDiv(){
        openForm.remove();
    }

});