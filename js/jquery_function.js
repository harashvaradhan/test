var host =window.location.hostname;
var divid;
var url ="http://localhost/MTP/";
$(function() {
$( document ).tooltip();
});
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
                if (validateFields(form)) {
                    var that =this;
                    addToWebsite(form,that);
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

    function validateFields(form)
{        var bValid = true,
            name = $('[name="name"]', form),

        bValid = bValid && checkLength(name, "website name", 3, 16);

        bValid = bValid && checkRegexp(name, /^[a-z]([0-9a-z_\ ])+$/i, "Website name may consist of a-z, 0-9, underscores, begin with a letter.");

        return bValid;
    }

    function addToWebsite(form,that) {
        var websitename =$('[name="name"]', form);
        website_name = websitename.val();
        jQuery.post( "includes/website-processing.php",
                {website_name:website_name},
                function(data, textStatus){
                if(data != 0){
                    $(that).dialog("close");
                    // window.location.href ='http://'+host+'/MTP/add-pages.php?website_id='+data;
                    window.location.href ='addpages/'+data;
                }else{
                    $(that).dialog("close");
                    alert('Some error occurred,please try agian');
                }

             });
    }
});
$(document).ready(function () {
$('#website_id').change(function () {
    var id = $(this).val();
    var site_title, keywords, description ;
    jQuery.post( "includes/seo-tags-processing.php",
        {id:id},
        function(data, textStatus){
            $('#sitetitle').val(data.site_title);
            $('#keywords').val(data.keyword);
            $('#description').val(data.meta_description);
            if ($('#sitetitle').val() =='' && $('#keywords').val() == '' && $('#description').val() == '') {
                $('#update').hide();
                $('#save').show();
            } else {
               $('#update').show();
               $('#save').hide();
            }
        },'json');
    });
$('#update').hide();
});
$(document).ready(function () {
    $('#create').hide();
    // $('#ok').click(function () {
    //     if($('#pagecount').val().trim() == null || $('#pagecount').val().trim() == ''){
    //         alert('Enter how many pages you want to create.');
    //     } else {
    //         if (isNaN($('#pagecount').val())) {
    //             alert('Only Numbers allowd');
    //         } else {
    //             var pagecount = $('#pagecount').val();
    //             jQuery('#pages').append("Number of pages you want :"+pagecount);
    //             for (var i = 1; i <= pagecount; i++) {
    //                 var input = jQuery("<label>Enter name of Page"+ i+"</label>:<input type='text' name ='page[]'>");
    //                 jQuery('#pages').append(input);
    //             }
    //             $('#pagecountdiv').hide();
    //             $('#create').show();
    //         }
    //     }
    // });

    $('#create').click(function () {
        var website_id = $('#website_id').val();
        var array = new Array();
        var i=0,j=0;
        var page = $('input[name="page[]"]');
        $.each(page, function(key, object) {
            if (object.value.trim() == '') {
                alert("Enter name of page "+(key+1));
                j++;    
                return false;
            };
        });
        if (j==0) {
            $.each(page, function(key, object) {
                 array[i++]= object.value.trim();
            });
            $.post(
                  "../includes/add-pages-processing.php",
                 { page: JSON.stringify(array), website_id:website_id},
                 function(data) {
                    if (data == 1) {
                        var loadurl =  "../loadcontents.php";
                        $('#dialog-add-menu').load(loadurl,{website_id:website_id});
                        $("#dialog-add-menu").dialog("open");
                    } else {
                        alert('pages not created');
                    }
                 }
             );
        };
    });

    $('#addpages').click(function () {
        divid = $('#pages div').size();
        if (divid >=0) {
            $(this).val('Add another page');
            $('#create').show();
        }
        var subdiv = $("<div id='subdiv"+divid+"' />");
        var input = $("<label>Page Name :</label><input type='text' name ='page[]'>");
        var removebutton = $("<input type='button' class='remove' value='X'>");
        subdiv.append(input);
        subdiv.append(removebutton);
        $('#pages').append(subdiv);
        removebutton.click(function () {
            $(this).parent().remove();
            divid = $('#pages div').size();
            divid--;
            if (divid < 0) {
            $('#addpages').val('Add page');
            $('#create').hide();
        }
        });
    });
    var form = $('#add-menu-form'),
        allFields = $(':checkbox', form);

    $("#dialog-add-menu").dialog({
        autoOpen:false,
        height: 400,
        width: 350,
        modal: true,
        draggable: false,
        resizable: false,
        buttons: {

            "Add to menu": function () {
                allFields.removeClass("ui-state-error");
                    var that =this;
                if (validateFields(form,that)) {
                      addToMenu(form,that);
                 }
            },
            Cancel: function () {
                $(this).dialog("close");
                window.location.href = "../websites";
            }
        },
        close: function () {
            allFields.val("").removeClass("ui-state-error");
            window.location.href = "../websites";
        }
    });

    function updateTips(t) {
        var tips = $(".validateTips");

        tips.text(t).addClass("ui-state-highlight");
        setTimeout(function () {
            tips.removeClass("ui-state-highlight", 1500);
        }, 500);
    }

    function validateFields (form,that) {
        var count = 0;
        $(that).find('input[type="checkbox"]').each(function(){
            if ($(this).is(':checked')) {
                count++;
            }
        });
        if (count < 1) {
            updateTips('Select at least on page.');
            return false;
        }
        else {
            return true;
        }
    }

    function addToMenu (form,that) {
        var array = new Array();
        $(that).find('input[type="checkbox"]').each(function(){
            array[$(this).val().toString()]= $(this).is(':checked');
        });
        var website_id =$('[name="website_id"]');
        website_id = website_id.val();
        jQuery.post( "../includes/add-menu-processing.php",
            {pages :array ,website_id:website_id},
            function(data, textStatus){
            if(data == 1){
                $(that).dialog("close");
                alert('Menu list updated');
                window.location.href = "../websites";
            }else{
                $(that).dialog("close");
                alert('Some error occurred,please try again.');
                window.location.href = "../websites";
            }
        });
    }
});

$(document).ready(function(){
    var form = $('#dialog-home-page'),
        allFields = $(':radio', form);

    $("#dialog-home-page").dialog({
        autoOpen:true,
        height: 400,
        width: 350,
        modal: true,
        draggable: false,
        resizable: false,
        buttons: {

            "Next": function () {
                allFields.removeClass("ui-state-error");
                    var that =this;
                if (validateFields(form,that)) {
                      addToMainPage(form,that);
                 }
            },
            Cancel: function () {
                $(this).dialog("close");
                window.location.href = "../websites";
            }
        },
        close: function () {
            allFields.val("").removeClass("ui-state-error");
            window.location.href = "../websites";
        }
    });

    function updateTips(t) {
        var tips = $(".validateTips");

        tips.text(t).addClass("ui-state-highlight");
        setTimeout(function () {
            tips.removeClass("ui-state-highlight", 1500);
        }, 500);
    }

    function validateFields(form,that) {
        var count = 0;
        $(that).find('input[type="radio"]').each(function(){
            if ($(this).is(':checked')) {
                count=1;
            }
        });
        if (count == 0) {
            updateTips("Select website's main page.");
            return false;
        }
        else {
            return true;
        }
    }
    function addToMainPage (form,that) {
        var page=0;
        $(that).find('input[type="radio"]').each(function(){
            if ($(this).is(':checked')) {
                page = $(this).val();
            }
        });
        var website_id =$('[name="website_id"]');
        website_id = website_id.val();
        jQuery.post("../includes/add-main-page.php",
            { page:page, website_id:website_id },
            function(data,textStatus) {
                alert(data);
                if(data == 1){
                $(that).dialog("close");
                alert('Main page of your website is now saved');
                window.location.href = "../websites";
            }else{
                $(that).dialog("close");
                alert('Some error occurred,please try again.');
                window.location.href = "../websites";
            }
        });
    }
});
/*
$(document).ready(function () {
    var form = $('#dialog-change-main-page'),
        allFields = $(':text', form);

    $("#dialog-change-main-page").dialog({
        autoOpen:true,
        height: 200,
        width: 350,
        modal: true,
        draggable: false,
        resizable: false,
        buttons: {

            "Set": function () {
                allFields.removeClass("ui-state-error");
                    var that =this;
                if (validateFields(form,that)) {
                      addToMainPage(form,that);
                 }
            },
            Cancel: function () {
                $(this).dialog("close");
                window.location.href = "../websites";
            }
        },
        close: function () {
            allFields.val("").removeClass("ui-state-error");
        }
    });
})*/