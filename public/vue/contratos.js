var app = new Vue({
    el: '#contratos',
    data: {
        message: 'Hello Vue!'
    },
    mounted(){
        let tableContratos = $('#tblContratos').DataTable({
            "dom":'lrtip',
            "language": {
                "url": dataTableLang
            },
        });
    }
})