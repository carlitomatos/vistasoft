var app = new Vue({
    el: '#imoveis',
    data: {
        message: 'Hello Vue!'
    },
    mounted(){
        let tableImoveis = $('#tblImoveis').DataTable({
            "dom":'lrtip',
            "language": {
                "url": dataTableLang
            },
        });
    }
})