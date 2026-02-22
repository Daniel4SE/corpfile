$(document).ready(function() {
    
    	$(document).on('click','.extend_btn',function(){
		
		var company_id =  $(this).attr('company_id'); 
		var agm_id =  $(this).attr('agm_id'); 
		var company_name =  $(this).attr('company_name'); 
		var fye_date =  $(this).attr('fye_date'); 
		var extended_due_date =  $(this).attr('extended_due_date'); 
		$('.modal_company_name').html(company_name);
		$('.modal_fye').html(fye_date); 
		$('.modal_company_id').val(company_id); 		 
		$('.modal_agm_id').val(agm_id); 
		
		$(".modal_extend_due_date option[value='remove_extend']").remove();
        /*
		if(extended_due_date != ''){
			$(".modal_extend_due_date").append('<option value="remove_extend">Remove Extend Date</option>'); 
		} */
		$('#extendModal').modal('show');		 
		$(".modal_extend_due_date_old").datepicker({
			dateFormat: 'dd/mm/yy'
		}); 		 
	});//end
    
    $(".save_btn").click(function(){ 
		
		var company_id	= $('.modal_company_id').val(); 
		var agm_id	= $('.modal_agm_id').val(); 
		var fye_date	= $('.modal_fye').val(); 
		var extend_due_date	= $('.modal_extend_due_date').val(); 
		if(extend_due_date == ""){ alert("Please Choose Extend Due Date!"); return false; } 
		$('#extend_form').submit();
		/*
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>company_agm/check_extended_due_date',
			data : "company_id="+company_id+"&agm_id="+agm_id+"&fye_date="+fye_date+"&extend_due_date="+extend_due_date,
			success:function(data){ 
				if(data=='NO'){
					alert("The date entered in this field should not be more than 60 days from the original 'AGM Due Date'!"); return false;				
				}else{
					$('#extend_form').submit();
				}
				  
			}
		});  
		*/
	});//end
    
    /*************************** AR ******************************/
    $(document).on('click','.extend_ar_btn',function(){
		
		var company_id =  $(this).attr('company_id'); 
		var agm_id =  $(this).attr('agm_id'); 
		var company_name =  $(this).attr('company_name'); 
		var fye_date =  $(this).attr('fye_date'); 
		var extended_due_date =  $(this).attr('extended_due_date'); 
		$('.ar_modal_company_name').html(company_name);
		$('.ar_modal_fye').html(fye_date); 
		$('.ar_modal_company_id').val(company_id); 		 
		$('.ar_modal_agm_id').val(agm_id); 
		
		
		$('#ar_extendModal').modal('show');		 
		$(".modal_extend_due_date_old").datepicker({
			dateFormat: 'dd/mm/yy'
		}); 		 
	});//end
    
    $(".ar_save_btn").click(function(){ 
		
		var company_id	      = $('.ar_modal_company_id').val(); 
		var agm_id	          = $('.ar_modal_agm_id').val(); 
		var fye_date	      = $('.ar_modal_fye').val(); 
		var extend_due_date	  = $('.ar_modal_extend_due_date').val(); 
        
		if(extend_due_date == ""){ alert("Please Choose Extend Due Date!"); return false; } 
        
		$('#ar_extend_form').submit();
	});//end
    
});//end doc