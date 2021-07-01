var app = new Vue({
    el: '#proprietarios',
    data: {
        message: 'Hello Vue!'
    },
    mounted(){
        let tableProprietarios = $('#tblProprietarios').DataTable({
            "dom":'lrtip',
            "language": {
                "url": dataTableLang
            },
        });
    }
})