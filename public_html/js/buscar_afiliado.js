$(document).ready(function(){
	$("#msj2").hide();
	$(".pager").hide();
	$("#fBuscar").submit(function(event){
		event.preventDefault();
		var data = {
			'dni': $('#numDni').val(),
			'apellido': $('#txtApellido').val(),
			'numafiliado': $('#numNAfiliado').val(),
			'mail': $('#txtMail').val(),
		};
		$.ajax({
                type: 'post',
                url: 'conexiones/buscar_afiliado.php',
                data: data,
                success: function(data){
					dat = jQuery.parseJSON(data);
					if (dat.length > 0){
						$("#msj1").hide();
						$("#msj2").hide();
						$(".pager").show();
						printres(dat);
						tablepager();
						}else{
							$("#bodyres").empty();
							$("#msj1").hide();
							$(".pager").hide();
							$("#msj2").show();
						}
					}
				});
	});
	
});

function act_bloc(id){
	console.log(id);
	var data = {
		'id':id
	};
	console.log(data);
	$.ajax({
		type:'post',
		url: 'conexiones/activar_bloquear.php',
		data: data,
		success:	function(data){
			dat = jQuery.parseJSON(data);
			console.log(dat);
			if (dat=='0'){
				$("button#"+id).removeClass('btn-danger').addClass('btn-success');
				$('button#'+id+' span').removeClass('glyphicon-ban-circle').addClass('glyphicon-ok-circle');
				showmodal(dat,id);
				}
			else{
				$("button#"+id).removeClass('btn-success').addClass('btn-danger');
				$('button#'+id+' span').removeClass('glyphicon-ok-circle').addClass('glyphicon-ban-circle');
				showmodal(dat,id);
				}
			}
		});
}

function showmodal(dat,id){
	if (dat==0){
		msj = "El afiliado Nº: "+id+" fue bloqueado exitosamente.";
	else if (dat==1){
		msj = "El afiliado Nº: "+id+" ahora se encuentra activo.";
		}
	else if (dat=="Denegado"){
		msj = "No tienes acceso a esta funcion.\nNo has iniciado sesión o no tienes los privilegios necesarios para esta operación."
		}
	$('p#pmsj1').text(msj);	
	$('#divInforme').modal()       
	$('#divInforme').modal({ keyboard: false })
	$('#divInforme').modal('show')  
}

function printres(dat){
	$("#bodyres").empty();
	$.each(dat, function(index, afiliado) {
		console.log(afiliado);
		id = afiliado['numAfi'];
		if (afiliado['activo'] == 1){		
			btnAB = '<button id = '+id+' class="btn btn-danger btn-sm" onclick="act_bloc('+id+');"><span class="glyphicon glyphicon-ban-circle"></span></button>';
		}else{
			btnAB = '<button id = '+id+' class="btn btn-success btn-sm" onclick="act_bloc('+id+');"><span class="glyphicon glyphicon glyphicon-ok-circle"></span></button>';
		}
		document.getElementById("bodyres").insertRow(0).innerHTML = '<tr><td>'+id+'</td><td>'+afiliado['nombre']+'</td><td>'+afiliado['dni']+'</td><td><p data-placement="top" data-toggle="tooltip" title="modificar datos"><button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span></button></p></td><td><button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button><button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-th-list"></span></button></p></td><td>'+btnAB+'</td></tr>';
	});
}

function tablepager(){
	$("#bodyres").trigger('refreshComplete');
	$("#bodyres").trigger('update');
	$("#bodyres").trigger('pagerUpdate');
	var pagerOptions = {

		// target the pager markup - see the HTML block below
		container: $(".pager"),

		// use this url format "http:/mydatabase.com?page={page}&size={size}&{sortList:col}"
		ajaxUrl: null,

		// modify the url after all processing has been applied
		customAjaxUrl: function(table, url) { return url; },

		// ajax error callback from $.tablesorter.showError function
		// ajaxError: function( config, xhr, settings, exception ){ return exception; };
		// returning false will abort the error message
		ajaxError: null,

		// add more ajax settings here
		// see http://api.jquery.com/jQuery.ajax/#jQuery-ajax-settings
		ajaxObject: { dataType: 'json' },

		// process ajax so that the data object is returned along with the total number of rows
		ajaxProcessing: null,

		// Set this option to false if your table data is preloaded into the table, but you are still using ajax
		processAjaxOnInit: true,

		// output string - default is '{page}/{totalPages}'
		// possible variables: {size}, {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
		// also {page:input} & {startRow:input} will add a modifiable input in place of the value
		// In v2.27.7, this can be set as a function
		// output: function(table, pager) { return 'page ' + pager.startRow + ' - ' + pager.endRow; }
		output: '{startRow:input} a {endRow} resultados ({totalRows})',

		// apply disabled classname (cssDisabled option) to the pager arrows when the rows
		// are at either extreme is visible; default is true
		updateArrows: true,

		// starting page of the pager (zero based index)
		page: 0,

		// Number of visible rows - default is 10
		size: 10,

		// Save pager page & size if the storage script is loaded (requires $.tablesorter.storage in jquery.tablesorter.widgets.js)
		//savePages : true,

		// Saves tablesorter paging to custom key if defined.
		// Key parameter name used by the $.tablesorter.storage function.
		// Useful if you have multiple tables defined
		//storageKey:'tablesorter-pager',

		// Reset pager to this page after filtering; set to desired page number (zero-based index),
		// or false to not change page at filter start
		pageReset: 0,

		// if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
		// table row set to a height to compensate; default is false
		fixedHeight: false,

		// remove rows from the table to speed up the sort of large tables.
		// setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
		removeRows: false,

		// If true, child rows will be counted towards the pager set size
		countChildRows: false,

		// css class names of pager arrows
		cssNext: '.next', // next page arrow
		cssPrev: '.prev', // previous page arrow
		cssFirst: '.first', // go to first page arrow
		cssLast: '.last', // go to last page arrow
		cssGoto: '.gotoPage', // select dropdown to allow choosing a page

		cssPageDisplay: '.pagedisplay', // location of where the "output" is displayed
		cssPageSize: '.pagesize', // page size selector - select dropdown that sets the "size" option

		// class added to arrows when at the extremes (i.e. prev/first arrows are "disabled" when on the first page)
		cssDisabled: 'disabled', // Note there is no period "." in front of this class name
		cssErrorRow: 'tablesorter-errorRow' // ajax error information row

	};
	$("table").tablesorter({theme: 'blue',widthFixed: true,sortLocaleCompare: false,widgets: ['zebra']});
	$("table").tablesorterPager(pagerOptions);
	$("table").trigger("updateAll");
}
