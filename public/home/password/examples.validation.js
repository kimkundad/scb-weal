(function() {

	'use strict';

	// basic
	// $("#form").validate({
	// 	highlight: function( label ) {
	// 		$(label).closest('.form-group').removeClass('has-success').addClass('has-error');
	// 	},
	// 	success: function( label ) {
	// 		$(label).closest('.form-group').removeClass('has-error');
	// 		label.remove();
	// 	},
	// 	errorPlacement: function( error, element ) {
	// 		var placement = element.closest('.form-row');
	// 		if (!placement.get(0)) {
	// 			placement = element;
	// 		}
	// 		if (error.text() !== '') {
	// 			placement.after(error);
	// 		}
	// 	}
	// });


	// validation summary
	var $summaryForm = $("#summary-form");
	$summaryForm.validate({
		errorContainer: $summaryForm.find( 'div.validation-message' ),
		errorLabelContainer: $summaryForm.find( 'div.validation-message ul' ),
		wrapper: "li"
	});

	// checkbox, radio and selects
	$("#chk-radios-form, #selects-form").each(function() {
		$(this).validate({
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error');
			}
		});
	});

}).apply(this, [jQuery]);

var check_email_format = null;

const validateEmail = (email) => {
    return email.match(
      /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
  };





var check_point_1 = null;
    var check_point_2 = null;
    var length_pass_1 = false;
    var number_pass_1 = false;
    var letter_pass_1 = false;
    var big_pass_1 = false;
    var same_pass_1 = false;

    var length_pass = document.getElementById("length_pass");
    var number_pass = document.getElementById("number_pass");
    var letter_pass = document.getElementById("letter_pass");
    var big_pass = document.getElementById("big_pass");
    var same_pass = document.getElementById("same_pass");
    document.getElementById('submit_newpass').disabled = true;

    $("#number_pass").prop("checked", false);
    $("#big_pass").prop("checked", false);
    $("#letter_pass").prop("checked", false);
    $("#length_pass").prop("checked", false);
    $("#same_pass").prop("checked", false);
    

    const validate = () => {
        const email = $('#email_create').val();
      
        if(validateEmail(email)){
            console.log('Email validation')
            $("#ch_email").prop("checked", true);
         
            if(length_pass_1 == true && number_pass_1 == true && letter_pass_1 == true && big_pass_1 == true ){
    
    
                // $('#submit_newpass').prop('disabled', false);
                if(check_point_1 == check_point_2){
                 
                 const email2 = $('#email_create').val();
    
                     $("#same_pass").prop("checked", true);
                     if(validateEmail(email2)){
                         
                         $('#submit_newpass').prop('disabled', false);
                     }
                     
                 }else{
                     $("#same_pass").prop("checked", false);
                     $('#submit_newpass').prop('disabled', true);
                 }
    
             }else{
                 $('#submit_newpass').prop('disabled', true);
                 $("#same_pass").prop("checked", false);
             }
    
         check_email_format === true
        } else{
            $('#submit_newpass').prop('disabled', true);
            console.log('Email invalidation')
            $("#ch_email").prop("checked", false);
            check_email_format === false
        //    $('#submit_newpass').prop('disabled', true);
        }
        return false;
      }
    
    
    $('#email_create').on('input', validate);


    function open_the_door(check_point1,check_point2){


        console.log('1--->', check_point1)
        console.log('2--->', check_point2)
        console.log('3--->', check_point_1)
        console.log('4--->', check_point_2)

        if(check_point1 == null){
            console.log('edit 1 after')
            check_point_2 = check_point2;
        }

        if(check_point2 == null){

            var numb = check_point1?.match(/\d/g);
            numb = numb?.join("");
          //  console.log(numb)
            if(numb != undefined){
                $("#number_pass").prop("checked", true);
                number_pass_1 = true;
            }else{
                $("#number_pass").prop("checked", false);
                number_pass_1 = false;
            }

            if((/[A-Z]/.test(check_point1)) === true){
                $("#big_pass").prop("checked", true);
                big_pass_1 = true
            }else{
                $("#big_pass").prop("checked", false);
                big_pass_1 = false
            }

            if((/[a-z]/.test(check_point1)) === true){
              //  console.log(/[a-z]/.test(val))
              $("#letter_pass").prop("checked", true);
                letter_pass_1 = true
            }else{
                $("#letter_pass").prop("checked", false);
                letter_pass_1 = false
            }

            if(check_point1?.length >= 8){
                $("#length_pass").prop("checked", true);
                length_pass_1 = true
            }else{
                $("#length_pass").prop("checked", false);
                length_pass_1 = false
            }

            check_point_1 = check_point1;

        }

        

           
if(length_pass_1 == true && number_pass_1 == true && letter_pass_1 == true && big_pass_1 == true ){



               // $('#submit_newpass').prop('disabled', false);
               if(check_point_1 == check_point_2){
                
                const email2 = $('#email_create').val();

                    $("#same_pass").prop("checked", true);
                    if(validateEmail(email2)){
                        
                        $('#submit_newpass').prop('disabled', false);
                    }
                    
                }else{
                    $("#same_pass").prop("checked", false);
                    $('#submit_newpass').prop('disabled', true);
                }

            }else{
                $('#submit_newpass').prop('disabled', true);
                $("#same_pass").prop("checked", false);
            }
        
            

        

    }



