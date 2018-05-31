<div id="wrap"> 
 
	<!-- Feedback message zone --> 
	<div id="message">
	</div> 

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
<script src="js/archicodtl.js" ></script> 

<script type="text/javascript"> 
 
           var datagrid = new DatabaseGrid(); 
	window.onload = function() {  

               // key typed in the filter field 
               $("#filter").keyup(function() { 
                   datagrid.editableGrid.filter( $(this).val()); 

                   // To filter on some columns, you can set an array of column index  
                   //datagrid.editableGrid.filter( $(this).val(), [0,3,5]); 
                 }); 
	};  
</script> 

 
        

