var Rutaid;
var Datatable;
var DatatableModal;

var Rutas = {
    listar: function () {
        var datos="";
        var targets=0;
        var estados =['.::Seleccione::.','Activo', 'Inactivo'];
        
        $('#tb_rutas').dataTable().fnDestroy();
        return $('#tb_rutas').on('page.dt', function () {
        }).on('search.dt', function () {
        }).on('order.dt', function () {
        })
        .DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "stateLoadCallback": function (settings) {
            },
            "stateSaveCallback": function (settings) {
            },
            ajax: function(data, callback, settings) {
                Rutas.http_ajax(data,callback);
            },
            "columns":[
                {data : function( row, type, val, meta) {
                    if (typeof row.id!="undefined" && typeof row.id!=undefined) {
                        return row.id;
                    } else return "";
                }, name:'id'},
                {data : function( row, type, val, meta) {
                    if (typeof row.origen!="undefined" && typeof row.origen!=undefined) {
                        return row.origen;
                    } else return "";
                }, name:'origen'},
                 {data : function( row, type, val, meta) {
                    if (typeof row.destino!="undefined" && typeof row.destino!=undefined) {
                        return row.destino;
                    } else return "";
                }, name:'destino'},
                {data : function( row, type, val, meta) {
                    for (var index in estados) {
                        if (index == row.estado) {
                            return estados[index];
                        }
                    }
                    return '';
                }, name:'estado'},
                {data : function( row, type, val, meta) {
                    htmlButtons = "<a class='btn btn-primary btn-md btn-detalle' data-toggle='modal' title='Conductores' ";
                    htmlButtons+=" data-target='#conductores' data-id='"+row.id+"'>";
                    htmlButtons+=" <i class='glyphicon glyphicon-th-list'></i></a>";

                    return htmlButtons;
                }, name:'botones'}
            ], 
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            order: [[ 1 , "desc" ]],
            info: true,
            autoWidth: true
        });
    },
    http_ajax: function(request,callback){
        var contador = 0;
        var form = $('#search_form').serialize().split('txt_').join("").split('slct_').join("");
        var order = request.order[0];
        form+='&column='+request.columns[ order.column ].name;
        form+='&dir='+order.dir;
        form+="&per_page="+request.length;
        form+="&page="+(request.start+request.length)/request.length;

        axios.get('listar-rutas?'+form).then( response => {
            callback(response.data);
        }).catch( e => {
        }).then(() => {
        });
    }
};

var Conductores = {
    listar: function (id) {
        var datos="";
        var targets=0;
        var estados =['.::Seleccione::.','Activo', 'Inactivo'];
        
        $('#tb_conductores').dataTable().fnDestroy();
        return $('#tb_conductores').on('page.dt', function () {
        }).on('search.dt', function () {
        }).on('order.dt', function () {
        })
        .DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "stateLoadCallback": function (settings) {
            },
            "stateSaveCallback": function (settings) {
            },
            ajax: function(data, callback, settings) {
                Conductores.http_ajax(data,callback,id);
            },
            "columns":[
                {data : function( row, type, val, meta) {
                    if (typeof row.id!="undefined" && typeof row.id!=undefined) {
                        return row.id;
                    } else return "";
                }, name:'id'},
                {data : function( row, type, val, meta) {
                    if (typeof row.nombre!="undefined" && typeof row.nombre!=undefined) {
                        return row.nombre;
                    } else return "";
                }, name:'nombre'},
                 {data : function( row, type, val, meta) {
                    if (typeof row.documento!="undefined" && typeof row.documento!=undefined) {
                        return row.documento;
                    } else return "";
                }, name:'documento'},
                {data : function( row, type, val, meta) {
                    for (var index in estados) {
                        if (index == row.estado) {
                            return estados[index];
                        }
                    }
                    return '';
                }, name:'estado'},
            ], 
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            order: [[ 1 , "desc" ]],
            info: true,
            autoWidth: true
        });
    },
    http_ajax: function(request,callback,id){
        var contador = 0;
        var form = $('#search_modal_form').serialize().split('txt_').join("").split('slct_').join("");
        var order = request.order[0];
        form+='&column='+request.columns[ order.column ].name;
        form+='&dir='+order.dir;
        form+="&per_page="+request.length;
        form+="&page="+(request.start+request.length)/request.length;

        axios.get('ruta/'+id+'/listar-conductores?'+form).then( response => {
            callback(response.data);
        }).catch( e => {
        }).then(() => {
        });
    }
};
$(document).ready(function(){

    $("#buscar").on( 'click', function(event) {
        Datatable = Rutas.listar();
    });
    $("#buscar_modal").on( 'click', function(event) {
        DatatableModal = Conductores.listar(Rutaid);
    });
    Datatable = Rutas.listar();
    $('#conductores').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        Rutaid = button.data('id');
        DatatableModal = Conductores.listar(Rutaid);
    });
    $('#conductores').on('hide.bs.modal', function (event) {
        Datatable = Rutas.listar();
    });
});