$( document ).ready(function() {
	var path="http://localhost/captura/captura-leadgen/public/";
	//var path="https://dev.captura.marketing/";
   	var bootstrap_enabled = (typeof $().modal == 'function');
   	var btn=''; 	

   	if (!bootstrap_enabled){
   		btn+='<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
		btn+='<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">';
		btn+='<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
   	}

   	btn+='<script src="https://use.fontawesome.com/a84158948e.js"></script>';

   	/*Custom CSS*/
   	btn+='<style>';
   	btn+='.star-rating {';
	  btn+='line-height:32px;';
	  btn+='font-size:3.5em;';
	btn+='}';	
	btn+='.star-rating .fa-star{color: yellow;}';
	btn+='.container{width: auto;}';
	btn+='</style>';

	btn+='<button type="button" id="review_btn" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">';
	btn+='Review';
	btn+='</button>';

	btn+='<div class="modal" id="myModal">';
		btn+='<div class="modal-dialog">';
			btn+='<div class="modal-content">';
				btn+='<div class="modal-header">';
					btn+='<button type="button" class="close" data-dismiss="modal">&times;</button>';
					btn+='<h4 class="modal-title">Can You Help Us Out With Your Feedback?</h4>';	
				btn+='</div>';

				btn+='<div class="modal-body">';
					btn+='<div class="container" id="captura-container" >';




						
						/*Form Opening*/
						btn+='<form id="review-front-form" action="" method="POST">';
						
							btn+='<input name="csrf-token" id="csrf-token" type="hidden"  />';

		 					btn+='<div class="form-group row" style="text-align:center;">';
		 						btn+='<div class="col-lg-12">';
		 							btn+='<p>Your feedback matters, and we\'d love to hear from you.</p>';
		 	 					btn+='</div>';
		  					btn+='</div>';

							btn+='<div class="form-group row" style="text-align:center;">';
								btn+='<div class="col-sm-12">';
			  						btn+='<div class="star-rating">';
									    btn+='<span class="fa fa-star-o" data-rating="1"></span>';
									    btn+='<span class="fa fa-star-o" data-rating="2"></span>';
									    btn+='<span class="fa fa-star-o" data-rating="3"></span>';
									    btn+='<span class="fa fa-star-o" data-rating="4"></span>';
									    btn+='<span class="fa fa-star-o" data-rating="5"></span>';
									    btn+='<input type="hidden" name="rating" id="rating" class="rating-value" value="0">';

									    btn+='<input type="hidden" name="depid" 	id="depid" />';
									    btn+='<input type="hidden" name="brandid" 	id="brandid" />';
			  						btn+='</div>';
								btn+='</div>';
							btn+='</div>';

						  	btn+='<div class="form-group row">';
							  	btn+='<div class="col-sm-12">';
							  		btn+='<textarea class="form-control" name="review_text" id="review_text" placeholder="Type your review text here..." required></textarea>';
							  	btn+='</div>';
						  	btn+='</div>';

							btn+='<div class="form-group row">';
								btn+='<div class="col-sm-5">';		
									btn+='<input class="form-control" name="name" id="name" type="text" placeholder="Name" required />';
								btn+='</div>';
								btn+='<div class="col-sm-5">';
									btn+='<input class="form-control" name="email" id="email" type="email" placeholder="Email" required />';
								btn+='</div>';
								btn+='<div class="col-sm-2">';
									btn+='<button type="submit" id="submit-review" class="btn btn-primary">Submit</button>';
									//data-dismiss="modal"
								btn+='</div>';
							btn+='</div>';

						btn+='</form>';
						
						/*Form Closing*/

					btn+='</div>';
				btn+='</div>';
			btn+='</div>';
		btn+='</div>';
	btn+='</div>';

	
	//Set csrf token
	$.get( path+"/generate_csrf_token", function( data ) {
	  $('#csrf-token').val( data );
	  //console.log(data);
	});


	$("#captura_review_form").html(btn);	


	$( "#depid" ).val( $( "#captura_review_form" ).attr( "depid" ) );
	$( "#brandid" ).val( $( "#captura_review_form" ).attr( "brandid" ) );


	var $star_rating = $('.star-rating .fa');
	var SetRatingStar = function() {
	  return $star_rating.each(function() {
	    if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
	      return $(this).removeClass('fa-star-o').addClass('fa-star');
	    } else {
	      return $(this).removeClass('fa-star').addClass('fa-star-o');
	    }
	  });
	};

	$star_rating.on('click', function() {
	  $star_rating.siblings('input.rating-value').val($(this).data('rating'));
	  return SetRatingStar();
	});

	/* attach a submit handler to the form */
	$("#review-front-form").submit(function(event) {	   
		/* stop form from submitting normally */
		event.preventDefault();	

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('#csrf-token').val()
		    }
		});		

		$.ajax({
            url: path+"submit-review",
            data: $(this).serialize(),
            type: 'POST',
            success: function(data){
                console.log(data);
            },
		    error: function (request, status, error) {
		        console.log(request.responseText);
		    },
		    beforeSend: function() {
		        // setting a timeout
		        $('#submit-review').text('Saving...');	
		        $('#submit-review').attr("disabled", "disabled")	        
		    },
		    complete: function() {		       
		        $('#submit-review').text('Submit');	
		        //setTimeout(function(){
				  $('#myModal').modal('hide')
				//}, 2000);
						        

		    },
        }); 


	});


	SetRatingStar();
});
