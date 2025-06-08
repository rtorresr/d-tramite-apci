class Documento {
    constructor(id, modal, url, idEntidad = 0) {        
        this.id = id;
        this.modal = modal;
        this.url = url;
        this.idEntidad = idEntidad;        
    };
    mostrarModal(titulo, contenido, btnFooter){
        $("#"+this.modal+" .modal-header").empty().append(titulo);
        $("#"+this.modal+" .modal-content").empty().append(contenido);
        $("#"+this.modal+" .modal-footer").empty().append(btnFooter);
        let modal = document.querySelector('#'+ this.modal);
        let modalInstance = M.Modal.getInstance(modal);
        modalInstance.open();
    }

    cerrarModal(){
        let modal = document.querySelector('#'+ this.modal);
        let modalInstance = M.Modal.getInstance(modal);
        modalInstance.close();
    }

    ver(){        
        debugger;
        var clase = this;        
        $.ajax({
            cache: false,
            url: urlpage + "views/ajax/obtenerDoc.php",
            method: "POST",
            data: {codigo: this.id, destino: this.idEntidad},
            datatype: "json",
            success: function (response) {
                let json = $.parseJSON(response);
                if (json.length !== 0) {
                    let titulo = '<h4>Documento</h4>';
                    let contenido = '<iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important" src="' + json['url'] + '"></iframe>';
                    let btnFooter = '<a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>';
                    clase.mostrarModal(titulo, contenido, btnFooter);
                }else {
                    M.toast({html: '¡No contiene documento asociado!'});
                }
            }
        });
    };

    mostrarUrl(){
        var clase = this;
        let titulo = '<h4>Documento</h4>';
        let contenido = '<iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important" src="'+ clase.url +'"></iframe>';
        let btnFooter = '<a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>';
        clase.mostrarModal(titulo, contenido, btnFooter);
    };

    anexos(){
        var clase = this;
        $.ajax({
            cache: false,
            url: urlpage + "views/verAnexo.php",
            method: "POST",
            data: {codigo: this.id, tabla: 't'},
            datatype: "json",
            success: function (response) {
                let json = $.parseJSON(response);
                if(json.tieneAnexos === '1') {
                    let titulo = '<h4>Anexos</h4>';
                    let contenido = '<ul class="fa-ul">';
                    json.anexos.forEach(function (elemento) {
                        contenido += '<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="'+elemento.url+'" target="_blank">'+elemento.nombre+'</a></li>';
                    });
                    contenido += '</ul>';
                    let btnFooter = '<a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>';
                    clase.mostrarModal(titulo, contenido, btnFooter);
                }else{
                    M.toast({html: '¡No contiene anexos!'});
                }
            }
        });
    }
    flujo(){
        var clase = this;
        if(this.id <= 7367){
            var documentophp = "flujodoc_old.php"
        } else{
            var documentophp = "flujodoc.php"
        }
        $.ajax({
            cache: false,
            url: urlpage + "views/" + documentophp,
            method: "POST",
            data: {codigo: this.id},
            datatype: "json",
            success: function (response) {
                let titulo = '<h4>Flujo</h4>';
                let contenido = response;
                let btnFooter = '<a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>';
                clase.mostrarModal(titulo, contenido, btnFooter);
            }
        });
    }
}
