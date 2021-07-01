var app = new Vue({
    el: '#proprietarios',
    data: {
        proprietarios: [],
        proprietario: {},
        tblProprietarios: {},
    },
    methods:{
        novo: function (){
            this.proprietario = {};
            $('.cadastro-proprietario').modal('show');
        },
        salvar: function (e){
            e.preventDefault();
            axios.post(this.$refs.salvarFormProprietario.action, {
                nome: this.proprietario.nome,
                email: this.proprietario.email,
                telefone: this.proprietario.telefone,
                dia_repasse: this.proprietario.dia_repasse,
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.tblProprietarios.ajax.reload();
            $('.cadastro-proprietario').modal('hide');
            this.proprietario = {};
        },
        atualizar: function (e){
            e.preventDefault();
            axios.put(this.$refs.atualizarFormProprietario.action, {
                proprietario_id: this.proprietario.proprietario_id,
                nome: this.proprietario.nome,
                email: this.proprietario.email,
                telefone: this.proprietario.telefone,
                dia_repasse: this.proprietario.dia_repasse,
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.tblProprietarios.ajax.reload();
            $('.update-proprietario').modal('hide');
            this.proprietario = {};
        },
        editar: function (id){
            this.proprietario = this.proprietarios.find( x => x.proprietario_id === id);
            $('.update-proprietario').modal('show');
        },
        apagar: function (id){
            axios.delete(urlApiProprietariosDelete + '/' + id)
                .then(function (response) {

                })
                .catch(function (error) {
                    console.log(error);
                });

            this.tblProprietarios.ajax.reload();
        },
        detalhes: function (id){
            axios.get(urlApiProprietariosDelete + '/' + id)
                .then(function (response) {
                    console.log(response);
                    app.proprietario = response.data;
                    $('.detalhes-proprietario').modal('show');
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
    mounted(){
        this.tblProprietarios = $('#tblProprietarios').DataTable({
            "dom":'lrtip',
            "language": {
                "url": dataTableLang
            },
            "serverSide": true,
            "columns" :[
                {"data": "proprietario_id"},
                {"data": "nome"},
                {"data": "email"},
                {"data": "telefone"},
                {"data": "dia_repasse"},
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<div>' +
                                    '<button onclick="app.editar('+"'"+row.proprietario_id+"'" +')" class="btn btn-warning m-r-5">Editar</button>' +
                                    '<button onclick="app.detalhes('+"'"+row.proprietario_id+"'" +')" class="btn btn-info m-r-5">Detalhes</button>' +
                                    '<button onclick="app.apagar('+"'"+row.proprietario_id+"'" +')" class="btn btn-danger m-r-5">Apagar</button>' +
                                '</div>'
                    },
                    "orderable": false
                },
            ],
            "ajax":{
                "url": urlApiProprietarios,
                "data": function (d) {
                },
                "beforeSend":function () {
                },
                "complete": function (response) {
                    app.proprietarios = response.responseJSON.data;
                },
                "error": function(response){
                    console.log(response)
                }
            },
        });
    }
})