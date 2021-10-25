$(document).ready(function() {
    var id_local, opcion;
    opcion = 4;
        
    tablaLocales = $('#tablaLocales').DataTable({  
        "ajax":{            
            "url": "crud.php", 
            "method": 'POST', //usamos el metodo POST
            "data":{opcion:opcion}, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },
        "columns":[
            {"data": "id_local"},
            {"data": "nombre_local"},
            {"data": "calle_local"},
            {"data": "cp_local"},
            {"data": "ciudad_local"},
            {"data": "lat_local"},
            {"data": "long_local"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
        ]
    });     
    
    var fila; //captura la fila, para editar o eliminar
    //submit para el Alta y Actualización
    $('#formLocales').submit(function(e){                         
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        nombre_local = $.trim($('#nombre_local').val());    
        calle_local = $.trim($('#calle_local').val());
        cp_local = $.trim($('#cp_local').val());    
        ciudad_local = $.trim($('#ciudad_local').val());    
        lat_local = $.trim($('#lat_local').val());
        long_local = $.trim($('#long_local').val());                          
            $.ajax({
              url: "bd/crud.php",
              type: "POST",
              datatype:"json",    
              data:  {id_local:id_local, nombre_local:nombre_local, calle_local:calle_local, cp_local:cp_local, ciudad_local:ciudad_local, lat_local:lat_local ,long_local:long_local ,opcion:opcion},    
              success: function(data) {
                tablalocales.ajax.reload(null, false);
               }
            });			        
        $('#modalCRUD').modal('hide');											     			
    });
         
//Editar        
$(document).on("click", ".btnEditar", function(){		        
    opcion = 2;//editar
    fila = $(this).closest("tr");	        
    id_local = parseInt(fila.find('td:eq(0)').text()); //capturo el ID		            
    nombre_local = fila.find('td:eq(1)').text();
    calle_local = fila.find('td:eq(2)').text();
    cp_local = fila.find('td:eq(3)').text();
    ciudad_local = fila.find('td:eq(4)').text();
    lat_local = fila.find('td:eq(5)').text();
    long_local = fila.find('td:eq(6)').text();
    $("#nombre_local").val(nombre_local);
    $("#calle_local").val(calle_local);
    $("#cp_local").val(cp_local);
    $("#ciudad_local").val(ciudad_local);
    $("#lat_local").val(lat_local);
    $("#long_local").val(long_local);
    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white" );
    $(".modal-title").text("Editar local");		
    $('#modalCRUD').modal('show');		   
});

//Borrar
$(document).on("click", ".btnBorrar", function(){
    fila = $(this);           
    id_local = parseInt($(this).closest('tr').find('td:eq(0)').text()) ;		
    opcion = 3; //eliminar        
    var respuesta = confirm("¿Está seguro de borrar el registro "+id_local+"?");                
    if (respuesta) {            
        $.ajax({
          url: "crud.php",
          type: "POST",
          datatype:"json",    
          data:  {opcion:opcion, id_local:id_local},    
          success: function() {
              tablaLocales.row(fila.parents('tr')).remove().draw();                  
           }
        });	
    }
 });
     
});    