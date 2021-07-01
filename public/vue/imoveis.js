var app = new Vue({
    el: '#imoveis',
    data: {
        imoveis: [],
        proprietarios: [],
        tblImoveis: {},
        imovel:{
           proprietario:{
               nome: ''
           },
           endereco:{}
       },
    },
    methods:{
        novo: function (){
            this.imovel = {
                proprietario:{
                    nome: ''
                },
                endereco:{}
            };
            $('.cadastro-imovel').modal('show');
        },
        salvar: function (e){
            e.preventDefault();
            axios.post(this.$refs.salvarFormImovel.action, {
                cep: this.imovel.endereco.cep,
                logradouro: this.imovel.endereco.logradouro,
                numero: this.imovel.endereco.numero,
                complemento: this.imovel.endereco.complemento,
                bairro: this.imovel.endereco.bairro,
                cidade: this.imovel.endereco.cidade,
                uf: this.imovel.endereco.uf,
                proprietario_id: this.imovel.proprietario.proprietario_id,

            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.tblImoveis.ajax.reload();
            $('.cadastro-imovel').modal('hide');
            this.imovel = {
                proprietario:{
                    nome: ''
                },
                endereco:{}
            };
        },
        atualizar: function (e){
            e.preventDefault();
            axios.put(this.$refs.atualizarFormImovel.action, {
                imovel_id: this.imovel.imovel_id,
                nome: this.imovel.nome,
                email: this.imovel.email,
                telefone: this.imovel.telefone,
                dia_repasse: this.imovel.dia_repasse,
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.tblImoveis.ajax.reload();
            $('.update-imovel').modal('hide');
            this.imovel = {
                proprietario:{
                    nome: ''
                },
                endereco:{}
            };
        },
        editar: function (id){
            this.imovel = this.imoveis.find( x => x.imovel_id === id);
            $('.update-imovel').modal('show');
        },
        apagar: function (id){
            axios.delete(urlApiImoveisDelete + '/' + id)
                .then(function (response) {

                })
                .catch(function (error) {
                    console.log(error);
                });

            this.tblImoveis.ajax.reload();
        },
        detalhes: function (id){
            axios.get(urlApiImoveisDelete + '/' + id)
                .then(function (response) {
                    console.log(response);
                    app.imovel = response.data;
                    $('.detalhes-imovel').modal('show');
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getProprietarios: function (){
            axios.get(urlApiProprietarios)
                .then(function (response) {
                    console.log(response);
                    app.proprietarios = response.data;
                    $('.lista-proprietarios').modal('show');
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        setProprietario: function (proprietario){
            this.imovel.proprietario = proprietario;
            $('.lista-proprietarios').modal('hide');
        }
    },
    mounted(){
        this.tblImoveis = $('#tblImoveis').DataTable({
            "dom":'lrtip',
            "language": {
                "url": dataTableLang
            },

            "serverSide": true,
            "columns" :[
                {"data": "imovel_id"},
                {"data": "nome"},
                {"data": "cidade"},
                {"data": "uf"},
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<div>' +
                            '<button onclick="app.editar('+"'"+row.imovel_id+"'" +')" class="btn btn-warning m-r-5">Editar</button>' +
                            '<button onclick="app.detalhes('+"'"+row.imovel_id+"'" +')" class="btn btn-info m-r-5">Detalhes</button>' +
                            '<button onclick="app.apagar('+"'"+row.imovel_id+"'" +')" class="btn btn-danger m-r-5">Apagar</button>' +
                            '</div>'
                    },
                    "orderable": false
                },
            ],
            "ajax":{
                "url": urlApiImoveis,
                "data": function (d) {
                },
                "beforeSend":function () {
                },
                "complete": function (response) {
                    app.imoveis = response.responseJSON.data;
                },
                "error": function(response){
                    console.log(response)
                }
            },
        });
    }
})