$(function () {

    var form = $('#newwebsite'),
        allFields = $(':text', form);
        
    $("#dialog-form").dialog({
        autoOpen: false,
        height: 225,
        width: 350,
        modal: true,
        draggable: false,
        resizable: false,
        buttons: {

            "Create Website": function () {
                allFields.removeClass("ui-state-error");
                // console.log(validateFields(form));
                if (validateFields(form)) {
                    var that =this;
                    addToUsers(form,that);
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        close: function () {
            allFields.val("").removeClass("ui-state-error");
        }
    });

    $("#create-website").button().click(function () {
        $("#dialog-form").dialog("open");
    });

    // Form validation
    
    function updateTips(t) {
        var tips = $(".validateTips");

        tips.text(t).addClass("ui-state-highlight");
        setTimeout(function () {
            tips.removeClass("ui-state-highlight", 1500);
        }, 500);
    }

    function checkLength(o, n, min, max) {
        var isValid = true;
        if (o.val().length > max || o.val().length < min) {
            o.addClass("ui-state-error");
            updateTips("Length of " + n + " must be between " + min + " and " + max + ".");
            isValid = false;
        }
        return isValid;
    }

    function checkRegexp(o, regexp, n) {
        var isValid = true;
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            updateTips(n);
            isValid = false;
        }
        return isValid;
    }

    function validateFields(form) {
        var bValid = true,
            name = $('[name="name"]', form),
     
        bValid = bValid && checkLength(name, "website name", 3, 16);
     
        bValid = bValid && checkRegexp(name, /^[a-z]([0-9a-z_])+$/i, "Website name may consist of a-z, 0-9, underscores, begin with a letter.");
     
        return bValid;
    }
    
    function addToUsers(form,that) {
        var websitename =$('[name="name"]', form);
        website_name = websitename.val();
        var host =window.location.hostname;
        jQuery.post("includes/website-processing.php", 
                {website_name:website_name},
                function(data, textStatus){
                if(data == 1){

                    $(that).dialog("close");
                    window.location.href ='http://'+host+'/MTP/create-website.php';
                }else{
                    $(that).dialog("close");
                    alert('Some error occurred,please try agian');
                }
        
             });
    }
});