jQuery(document).ready(function($) { //wrapper
	    console.log("Loading")
        $(".vectors-filter-button").click(function() { 
            page_link = window.location.href
			console.log(page_link)
            cateogory_name = page_link.split('/')[4];
			console.log(cateogory_name)
            $.ajax({
             url: my_ajax_object.ajax_url,
             method : 'POST',
             data: {
                 action: 'vector_filter',
                 category_name : cateogory_name
                 
             },
             success: function(res){
				  console.log("Mustafa you are great")
				  console.log(res);
//                   $("#change").html(res);
				 
             },
             error : function(error){ 
                 console.log("Error")
             }
  });
        });

        $(".templates-filter-button").click(function() { 
            page_link = window.location.href
            cateogory_name = page_link.split('/')[4];
            $.ajax({
             url: my_ajax_object.ajax_url,
             method : 'POST',
             data: {
                 action: 'template_filter',
                 category_name : cateogory_name
                 
             },
             success: function(res){
                  $("#change").html(res);
             },
             error : function(error){ 
                 console.log("Error")
             }
  });
        });
       
    });