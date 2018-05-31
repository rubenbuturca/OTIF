<div id="wrap"> 
 
	<!-- Feedback message zone --> 
	<div id="message"></div> 

           <div id="toolbar"> 
             <input type="text" id="filter" name="filter" placeholder="Filter :type any text here"  /> 
             <!--a id="showaddformbutton" class="button green"><i class="fa fa-plus"></i> Add new row</a--> 
           </div> 
	<!-- Grid contents --> 
	<div id="tablecontent"></div> 
 
	<!-- Paginator control --> 
	<div id="paginator"></div> 
</div>   
 
<script src="js/editablegrid-2.1.0-b25.js"></script>    
<script src="js/jquery-1.11.1.min.js" ></script> 
       <!-- EditableGrid test if jQuery UI is present. If present, a datepicker is automatically used for date type --> 
       <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script> 
<script src="js/archico.js" ></script> 

<script type="text/javascript"> 
 
           var datagrid = new DatabaseGrid(); 
	window.onload = function() {  

               // key typed in the filter field 
               $("#filter").keyup(function() { 
                   datagrid.editableGrid.filter( $(this).val()); 

                   // To filter on some columns, you can set an array of column index  
                   //datagrid.editableGrid.filter( $(this).val(), [0,3,5]); 
                 }); 

               $("#showaddformbutton").click( function()  { 
                 showAddForm(); 
               }); 
               $("#cancelbutton").click( function() { 
                 showAddForm(); 
               }); 

               $("#addbutton").click(function() { 
                 datagrid.addRow(); 
               }); 

        
	};  
</script> 

       <!-- simple form, used to add a new row --> 
       <div id="addform"> 

           <div class="row"> 
               <input type="text" id="name" name="name" placeholder="name" /> 
           </div> 

            <div class="row"> 
               <input type="text" id="firstname" name="firstname" placeholder="firstname" /> 
           </div> 

           <div class="row tright"> 
             <a id="addbutton" class="button green" ><i class="fa fa-save"></i> Apply</a> 
             <a id="cancelbutton" class="button delete">Cancel</a> 
           </div> 
       </div> 
        

