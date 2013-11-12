function mostrarTabla(){
	var asInitVals = new Array();

	var oTable;

	/*borrar elemento seleccionandolo*/
	/* Add a click handler to the rows - this could be used as a callback */
    $("#datatables tbody tr").click( function( e ) {
        if ( $(this).hasClass('row_selected') ) {
            $(this).removeClass('row_selected');
        }
        else {
            $('#datatables tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
        }
    });
     
    /* Add a click handler for the delete row */
    $('#delete').click( function() {
        var anSelected = fnGetSelected( );
        if ( anSelected.length !== 0 ) {
			if (confirm("Eliminara el elemento seleccionado")){
				deleteRow(ObtenerIdFilaSeleccionada());
				oTable.fnDeleteRow( anSelected[0] );
			}
        }
    } );
    /*fin del borrar*/
    /* Init the table */
	
	 var oTable = $('#datatables').dataTable({
	"fnDrawCallback": function ( oSettings ) {
            /* cuenta el total de filas */
            if ( oSettings.bSorted || oSettings.bFiltered )
            {
                $('td:first-child', {"filter":"applied"}).each( function (i) {
                    that.fnUpdate( i+1, this.parentNode, 0, false, false );
                } );
            }
        },
		"sPaginationType":"full_numbers",
	   "aaSorting":[[0, "asc"]],
		"bJQueryUI":true,
		"oLanguage": {
            "sSearch": "Search all columns:"
        }
    } );
     
    $("tfoot input").keyup( function () {
        /* Filter on the column (the index) of this element */
        oTable.fnFilter( this.value, $("tfoot input").index(this) );
    } );
	
	$("tfoot input").each( function (i) {
        asInitVals[i] = this.value;
    } );
     
    $("tfoot input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
     
    $("tfoot input").blur( function (i) {
        if ( this.value == "" )
        {
            this.className = "search_init";
            this.value = asInitVals[$("tfoot input").index(this)];
        }
    } );
	


}

/* Get the rows which are currently selected */
function fnGetSelected(  )
{
    return $('#datatables tr.row_selected');
}

function ObtenerIdFilaSeleccionada(  )
{
	return($('#datatables tr.row_selected td:first-child')[0].getAttribute('name'));
}

function deleteRow(id){
	/*FUNCION TIPICA DE AJAX*/
	

	tabla = (document.getElementById('tabla').getAttribute('name'));
	var parametros = {
		"id" : id,
		"accion" : "baja",
		"tabla" : tabla 
	};
	
/*	var resultado = cargarpaginasinc('abm.php', parametros);	/*SIMILAR A AJAX DE ABAJO PERO PARA VER SU USO
	alert(resultado); 
*/		

	var ajax = $.ajax({
		data:  parametros,
		url:   'abm.php',
		type:  'post',
		/*beforeSend: function () {
			$("#resultado").html("Procesando, espere por favor...");
		},*/
		success:  function (data) {
			alert('Ud elimino '+ajax.responseText+' elemento');
		}
	});
}


function addForm(){
	if(document.getElementById('addDiv').style.display=='block'){
		document.getElementById('addDiv').style.display='none';
		document.getElementById('datatables_wrapper').style.display='block';
		document.getElementById('btnadd').style.backgroundImage="url('../view/img/add.png')";
	
	}else{
		document.getElementById('btnadd').style.backgroundImage="url('../view/img/sub.png')";
		document.getElementById('addDiv').style.display='block';
		document.getElementById('datatables_wrapper').style.display='none';
	}
}