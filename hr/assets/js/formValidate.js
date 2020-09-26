
    var $_preLoader = '<div style="text-align:center;"><img src="'+base_url+'public/images/preloader.gif"/></div>';
    var $_imgHtml = '<img src="" class="file-preview-image" title="" style="height:auto;max-width:80%;max-height:80%; margin-top: -80px; margin-bottom: -70px;">';
   //  $(document).ready(function () {
   //     if(msg_type.length > 0) {
   //         if (msg_type == 'success') {
   //             $("#sweet-welcome-btn").click();
   //         }
   //     }
   // });

   $(document).on('click', '#sweet-welcome-btn', function(){
       swal({
           position: 'top-end',
           title: "Welcome",
           text: message,
           timer: 2000,
           showConfirmButton: !1
       });
       $.ajax({
           url: base_url+"layout/messageSessionDestroy.php",
           success: function (res) {
               if(res) { }
           }
       });
   });


   $(".onlyNumber").keypress(function (e) {
       var keyCode = e.keyCode || e.which;
       var regex = /^[0-9]+$/;
       var isValid = regex.test(String.fromCharCode(keyCode));
       if (!isValid) {
           return false;
       }
       return true;
   });

    function onlyNumber(e) {
        var charCode = e.keyCode;
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 8) {
            return false;
        }
        return true;
    }
   function isValidate(formId) {
       $(".err-msg").html('');
       $(".validate-field").removeClass('validate-field');
       var status = 'true';
       var inputField = $(formId+" .inputField");
       if (inputField.length > 0) {
           $(inputField).each(function (index, value) {
               var fieldType = $(this).data('type');
               if(fieldType == 'text' || fieldType == 'file' || fieldType == 'select') {
                   if ((this.value.length < 1 || this.value == '') && $(this).data('validate') != '' && $(this).data('validate') == 'required') {
                       $(formId+" .err-msg").html($(this).data('message'));
                       $(this).addClass('validate-field').focus();
                       status = 'false';
                       return false;
                   }
               }
               if(fieldType == 'email'){
                   if (this.value.length < 1 && $(this).data('validate') == 'required') {
                       $(formId+" .err-msg").html($(this).data('message'));
                       $(this).addClass('validate-field').focus();
                       status = 'false';
                       return false;
                   }

                   if(this.value.length > 0 && !isEmail(this.value)){
                       $(formId+" .err-msg").html('Please Fill Valid Email Address.');
                       $(this).addClass('validate-field').focus();
                       status = 'false';
                       return false;
                   }
               }

               if(fieldType == 'radio'){
                   var name = this.name;
                   if($('input[name="'+name+'"]:checked').length < 1){
                       $(formId+" .err-msg").html($(this).data('message'));
                       status = 'false';
                       return false;
                   }
               }
           });
       }
       return status;
   }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }