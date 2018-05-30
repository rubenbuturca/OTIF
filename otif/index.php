<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Archico OTIF</title>
		
		<!-- include javascript and css files for the EditableGrid library -->
		<script src="http://www.archico.lt/otif/javascript/editablegrid.js"></script>
		<!-- [DO NOT DEPLOY] --> <script src="http://www.archico.lt/otif/javascript/editablegrid_renderers.js" ></script> 
		<!-- [DO NOT DEPLOY] --> <script src="http://www.archico.lt/otif/javascript/editablegrid_editors.js" ></script> 
		<!-- [DO NOT DEPLOY] --> <script src="http://www.archico.lt/otif/javascript/editablegrid_validators.js" ></script> 
		<!-- [DO NOT DEPLOY] --> <script src="http://www.archico.lt/otif/javascript/editablegrid_utils.js" ></script> 
		<!-- [DO NOT DEPLOY] --> <script src="http://www.archico.lt/otif/javascript/editablegrid_charts.js" ></script> 
		<link rel="stylesheet" href="http://www.archico.lt/otif/css/editablegrid.css" type="text/css" media="screen">

		<!-- include javascript and css files for jQuery, needed for the datepicker and autocomplete extensions -->
		<script src="http://www.archico.lt/otif/extensions/jquery/jquery-1.6.4.min.js" ></script>
		<script src="http://www.archico.lt/otif/extensions/jquery/jquery-ui-1.8.16.custom.min.js" ></script>
		<link rel="stylesheet" href="http://www.archico.lt/otif/extensions/jquery/jquery-ui-1.8.16.custom.css" type="text/css" media="screen">
		
		<!-- include javascript and css files for the autocomplete extension -->
		<script src="http://www.archico.lt/otif/extensions/autocomplete/autocomplete.js" ></script>
		<link rel="stylesheet" href="http://www.archico.lt/otif/extensions/autocomplete/autocomplete.css" type="text/css" media="screen">

		<!-- Uncomment this if you want to use the first variant of the autocomplete instead of the official one from jQuery UI -->
		<!--
		<script src="http://www.archico.lt/otif/extensions/autocomplete_variant_1/jquery.autocomplete.min.js" ></script>
		<script src="http://www.archico.lt/otif/extensions/autocomplete_variant_1/autocomplete.js" ></script>
		<link rel="stylesheet" href="http://www.archico.lt/otif/extensions/autocomplete_variant_1/jquery.autocomplete.css" type="text/css" media="screen">
		!-->

		<!-- Uncomment this if you want to use the second variant of the autocomplete instead of the official one from jQuery UI -->
		<!--
		<script src="http://www.archico.lt/otif/extensions/autocomplete_variant_2/jquery.autocomplete.min.js" ></script>
		<script src="http://www.archico.lt/otif/extensions/autocomplete_variant_2/autocomplete.js" ></script>
		<link rel="stylesheet" href="http://www.archico.lt/otif/extensions/autocomplete_variant_2/jquery.autocomplete.css" type="text/css" media="screen">
		!-->

		<!-- include javascript file for the Highcharts library -->
		<script src="http://www.archico.lt/otif/extensions/Highcharts-4.0.4/js/highcharts.js"></script>

		<!-- include javascript and css files for this demo -->
		<!-- <script src="javascript/demo.js" ></script> -->
		<link rel="stylesheet" type="text/css" href="css/archico.css" media="screen"/>
		<script type="text/javascript">
			//create our editable grid
			var editableGrid = new EditableGrid("DemoGridFull", {
				enableSort: true, // true is the default, set it to false if you don't want sorting to be enabled
				editmode: "absolute", // change this to "fixed" to test out editorzone, and to "static" to get the old-school mode
				editorzoneid: "edition", // will be used only if editmode is set to "fixed"
				pageSize: 10,
				maxBars: 10
			});

			//helper function to display a message
			function displayMessage(text, style) { 
				_$("message").innerHTML = "<p class='" + (style || "ok") + "'>" + text + "</p>"; 
			} 

			//helper function to get path of a demo image
			function image(relativePath) {
				return "images/" + relativePath;
			}

			//this will be used to render our table headers
			function InfoHeaderRenderer(message) { 
				this.message = message; 
				this.infoImage = new Image();
				this.infoImage.src = image("information.png");
			};

			InfoHeaderRenderer.prototype = new CellRenderer();
			InfoHeaderRenderer.prototype.render = function(cell, value) 
			{
				if (value) {
					// here we don't use cell.innerHTML = "..." in order not to break the sorting header that has been created for us (cf. option enableSort: true)
					var link = document.createElement("a");
					link.href = "javascript:alert('" + this.message + "');";
					link.appendChild(this.infoImage);
					cell.appendChild(document.createTextNode("\u00a0\u00a0"));
					cell.appendChild(link);
				}
			};
			EditableGrid.prototype.onloadJSON = function(url) 
			{
				// register the function that will be called when the XML has been fully loaded
				this.tableLoaded = function() { 
					displayMessage("Grid loaded from JSON: " + this.getRowCount() + " row(s)"); 
					this.initializeGrid();
				};

				// load JSON URL
				this.loadJSON(url);
			};
			//this function will initialize our editable grid
			EditableGrid.prototype.initializeGrid = function() 
			{
				with (this) {
					// update paginator whenever the table is rendered (after a sort, filter, page change, etc.)
					tableRendered = function() { this.updatePaginator(); };

					// update charts when the table is sorted or filtered
					tableFiltered = function() { this.renderCharts(); };
					tableSorted = function() { this.renderCharts(); };

					rowSelected = function(oldRowIndex, newRowIndex) {
						if (oldRowIndex < 0) displayMessage("Selected row '" + this.getRowId(newRowIndex) + "'");
						else displayMessage("Selected row has changed from '" + this.getRowId(oldRowIndex) + "' to '" + this.getRowId(newRowIndex) + "'");
					};

					rowRemoved = function(oldRowIndex, rowId) {
						displayMessage("Removed row '" + oldRowIndex + "' - ID = " + rowId);
					};

					// render for the action column
					setCellRenderer("action", new CellRenderer({render: function(cell, value) {
						// this action will remove the row, so first find the ID of the row containing this cell 
						var rowId = editableGrid.getRowId(cell.rowIndex);

						// cell.innerHTML = "<a onclick=\"if (confirm('Are you sure you want to delete this project ? ')) { editableGrid.remove(" + cell.rowIndex + "); editableGrid.renderCharts(); } \" style=\"cursor:pointer\">" +
										// "<img src=\"" + image("delete.png") + "\" border=\"0\" alt=\"delete\" title=\"Delete row\"/></a>";
						var deleteAjaxCode="$.ajax({url: 'delete.php',type: 'POST',dataType: \"html\",data: {tablename : self.editableGrid.name,id: id },success: function (response) { if (response == \"ok\" ) {message(\"success\",\"Row deleted\"); self.fetchGrid(); }},error: function(XMLHttpRequest, textStatus, exception) { alert(\"Ajax failure\n\" + errortext); },	async: true	});";
						cell.innerHTML = "<a onclick=\"if (confirm('Are you sure you want to delete this project ? ')) {" + deleteAjaxCode + } \" style=\"cursor:pointer\"><img src=\"" + image("delete.png") + "\" border=\"0\" alt=\"delete\" title=\"Delete row\"/></a>";

						cell.innerHTML+= "&nbsp;<a onclick=\"editableGrid.duplicate(" + cell.rowIndex + ");\" style=\"cursor:pointer\">" +
						"<img src=\"" + image("duplicate.png") + "\" border=\"0\" alt=\"duplicate\" title=\"Duplicate row\"/></a>";

					}})); 

					// render the grid (parameters will be ignored if we have attached to an existing HTML table)
					renderGrid("tablecontent", "testgrid", "tableid");

					// set active (stored) filter if any
					_$('filter').value = currentFilter ? currentFilter : '';

					// filter when something is typed into filter
					_$('filter').onkeyup = function() { editableGrid.filter(_$('filter').value); };

					// bind page size selector
					$("#pagesize").val(pageSize).change(function() { editableGrid.setPageSize($("#pagesize").val()); });
					$("#barcount").val(maxBars).change(function() { editableGrid.maxBars = $("#barcount").val(); editableGrid.renderCharts(); });
				}
			};
			//function to render the paginator control
			EditableGrid.prototype.updatePaginator = function()
			{
				var paginator = $("#paginator").empty();
				var nbPages = this.getPageCount();

				// get interval
				var interval = this.getSlidingPageInterval(20);
				if (interval == null) return;

				// get pages in interval (with links except for the current page)
				var pages = this.getPagesInInterval(interval, function(pageIndex, isCurrent) {
					if (isCurrent) return "" + (pageIndex + 1);
					return $("<a>").css("cursor", "pointer").html(pageIndex + 1).click(function(event) { editableGrid.setPageIndex(parseInt($(this).html()) - 1); });
				});

				// "first" link
				var link = $("<a>").html("<img src='" + image("gofirst.png") + "'/>&nbsp;");
				if (!this.canGoBack()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
				else link.css("cursor", "pointer").click(function(event) { editableGrid.firstPage(); });
				paginator.append(link);

				// "prev" link
				link = $("<a>").html("<img src='" + image("prev.png") + "'/>&nbsp;");
				if (!this.canGoBack()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
				else link.css("cursor", "pointer").click(function(event) { editableGrid.prevPage(); });
				paginator.append(link);

				// pages
				for (p = 0; p < pages.length; p++) paginator.append(pages[p]).append(" | ");

				// "next" link
				link = $("<a>").html("<img src='" + image("next.png") + "'/>&nbsp;");
				if (!this.canGoForward()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
				else link.css("cursor", "pointer").click(function(event) { editableGrid.nextPage(); });
				paginator.append(link);

				// "last" link
				link = $("<a>").html("<img src='" + image("golast.png") + "'/>&nbsp;");
				if (!this.canGoForward()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
				else link.css("cursor", "pointer").click(function(event) { editableGrid.lastPage(); });
				paginator.append(link);
			};
			//function to render our two demo charts
			EditableGrid.prototype.renderCharts = function() 
			{
				this.renderBarChart("barchartcontent", 'Cost per project' + (this.getRowCount() <= this.maxBars ? '' : ' (first ' + this.maxBars + ' rows out of ' + this.getRowCount() + ')'), 'address', { limit: this.maxBars, bar3d: false, rotateXLabels: this.maxBars > 10 ? 270 : 0 });
				this.renderPieChart("piechartcontent", 'Touch Time distribution', 'real_touchtime', 'address');
			};
			EditableGrid.prototype.duplicate = function(rowIndex) 
			{
				// copy values from given row
				var values = this.getRowValues(rowIndex);
				values['name'] = values['name'] + ' (copy)';

				// get id for new row (max id + 1)
				var newRowId = 0;
				for (var r = 0; r < this.getRowCount(); r++) newRowId = Math.max(newRowId, parseInt(this.getRowId(r)) + 1);

				// add new row
				this.insertAfter(rowIndex, newRowId, values); 
			};

			window.onload = function() { 
				// you can use "datasource/demo.php" if you have PHP installed, to get live data from the demo.csv file
				editableGrid.onloadJSON("http://www.archico.lt/otif/datasource/loadprojects.php"); 
				// editableGrid.onloadJSON("datasource/demo.php"); 
			}; 
		</script>

	</head>
	
	<body>
		<div id="wrap">
		<h1></h1> 
		
			<!-- Feedback message zone -->
			<div id="message"></div>

			<!--  Number of rows per page and bars in chart -->
			<div id="pagecontrol">
				<label for="pagecontrol">Rows per page: </label>
				<select id="pagesize" name="pagesize">
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="15">15</option>
					<option value="20">20</option>
					<option value="25">25</option>
					<option value="30">30</option>
					<option value="40">40</option>
					<option value="50">50</option>
				</select>
				&nbsp;&nbsp;
				<label for="barcount">Bars in chart: </label>
				<select id="barcount" name="barcount">
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="15">15</option>
					<option value="20">20</option>
					<option value="25">25</option>
					<option value="30">30</option>
					<option value="40">40</option>
					<option value="50">50</option>
				</select>	
			</div>
		
			<!-- Grid filter -->
			<label for="filter">Filter :</label>
			<input type="text" id="filter"/>
		
			<!-- Grid contents -->
			<div id="tablecontent"></div>
			<!-- [DO NOT DEPLOY] --> <?php if (isset($_GET['attach'])) include("htmlgrid.html"); ?>	
		
			<!-- Paginator control -->
			<div id="paginator"></div>
		
			<!-- Edition zone (to demonstrate the "fixed" editor mode) -->
			<div id="edition"></div>
			
			<!-- Charts zone -->
			<div id="barchartcontent"></div>
			<div id="piechartcontent"></div>
			
		</div>
	</body>

</html>
