$(document).ready(function() {

      var a = 0;
	
      var   activation_model = '<div id="activation_modal" class="modal fade" role="dialog">';
      	activation_model +=  '<form action="#">';
      	activation_model +=  '<div class="modal-dialog">';
      	activation_model +=  	'<div class="modal-content">';
      	activation_model +=  		'<div class="modal-header">';
      	activation_model += 			'<button type="button" class="close" data-dismiss="modal">&times;</button>';
            activation_model += 			'<h4 class="modal-title">Activate your purchase</h4>';
            activation_model += 		'</div>';
            activation_model += 		'<div class="modal-body">';
            activation_model +=			'<div class="row">';
            activation_model +=				'<div class="col-md-12">';
            activation_model +=					'<div class="form-group">';
            activation_model +=						'<label for="email">Email</label>';
      	activation_model +=						'<input type="text" name="email" class="form-control" placeholder="Enter Registered Email"></label>';
      	activation_model +=						'<span class="validation-color" id="err_email"></span>';
      	activation_model +=					'<div>';
            activation_model +=					'<div class="form-group">';
            activation_model +=						'<label for="purchase_code">Purchase Code Or API Key</label>';
            activation_model +=						'<input type="text" name="purchase_code" class="form-control" placeholder="Enter Purchase Code"></label>';
      	activation_model +=						'<span class="validation-color" id="err_purchase_code"></span>';
      	activation_model +=					'</div>';
            activation_model +=				'</div>';
            activation_model +=			'</div>';
            activation_model += 		'</div>';
            activation_model += 		'<div class="modal-footer">';
      	activation_model +=			'<div class="row">';
            activation_model +=				'<div class="col-md-12">';
            activation_model +=					'<div class="form-group">';
      	activation_model +=						'<button type="submit" name="submit" class="btn-info btn pull-left" value="Submit">Submit</button>';		
      	activation_model +=						'<button type="reset" name="reset" class="btn-info btn pull-left" value="Reset">Reset</button>';		
      	activation_model +=						'<a href="http://www.vakratundasystem.in" class="btn-info btn pull-right" target="_blank">Generate API Key</button>';		
      	activation_model +=					'</div>';
            activation_model +=				'</div>';
            activation_model +=			'</div>';
            activation_model += 		'</div>';
            activation_model += 	'</div>';
            activation_model +=  '</div>';
            activation_model +=  '</form>';
            activation_model +='</div>';

      var   $activation_model = $(activation_model);

      $(".main-footer").after($activation_model);
            
      if(a==0){
            $('#activation_modal').modal('toggle');      
      }

      


});

function check_activation() {

	var activation_model = '<div id="myModal" class="modal fade" role="dialog">';
		  activation_model +=  '<div class="modal-dialog">';
		  activation_model +=  	'<div class="modal-content">';
		  activation_model +=  		'<div class="modal-header">';
		  activation_model += 			'<button type="button" class="close" data-dismiss="modal">&times;</button>';
      activation_model += 			'<h4 class="modal-title">Modal Header</h4>';
      activation_model += 		'</div>';
      activation_model += 		'<div class="modal-body">';
      activation_model +=				'<p>Some text in the modal.</p>';
      activation_model += 		'</div>';
      activation_model += 		'<div class="modal-footer">';
      activation_model +=				'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
      activation_model += 		'</div>';
      activation_model += 	'</div>';
      activation_model +=  '</div>';
      activation_model +='</div>';
    
}

//document.onload = check_activation();