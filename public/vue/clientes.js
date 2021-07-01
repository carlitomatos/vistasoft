var app = new Vue({
    el: '#clientes',
    data: {
        clientes: [],
        cliente: {},
        tblClientes: {},
        teste: 'TESTE'
    },
    methods:{
        novoCliente: function (){
            this.cliente = {};
            $('.cadastro-cliente').modal('show');
        },
        salvar: function (e){
            e.preventDefault();
            axios.post(this.$refs.salvarForm.action, {
                nome: this.cliente.nome,
                email: this.cliente.email,
                telefone: this.cliente.telefone
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.tblClientes.ajax.reload();
            $('.cadastro-cliente').modal('hide');
            this.cliente = {};
        },
        atualizar: function (e){
            e.preventDefault();
            axios.put(this.$refs.atualizarForm.action, {
                cliente_id: this.cliente.cliente_id,
                nome: this.cliente.nome,
                email: this.cliente.email,
                telefone: this.cliente.telefone
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.tblClientes.ajax.reload();
            $('.update-cliente').modal('hide');
            this.cliente = {};
        },
        editarCliente: function (id){
            this.cliente = this.clientes.find( x => x.cliente_id === id);
            $('.update-cliente').modal('show');
        },
        apagar: function (id){
            axios.delete(urlApiClientesDelete + '/' + id)
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });

            this.tblClientes.ajax.reload();
        }
    },
    mounted(){
        this.tblClientes = $('#tblClientes').DataTable({
            "dom":'lrtip',
            "language": {
                "url": dataTableLang
            },
            "serverSide": true,
            "columns" :[
                {"data": "cliente_id"},
                {"data": "nome"},
                {"data": "email"},
                {"data": "telefone"},
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<button onclick="app.editarCliente('+"'"+row.cliente_id+"'" +')" class="btn btn-warning">Editar</button>' +
                         '<button onclick="app.apagar('+"'"+row.cliente_id+"'" +')" class="btn btn-danger">Apagar</button>'
                    },
                    "className":'exames'
                },
            ],

            "ajax":{
                "url": urlApiClientes,
                //"type": "POST",
                "data": function (d) {
                },
                "beforeSend":function () {
                },
                "complete": function (response) {
                    app.clientes = response.responseJSON.data;
                },
                "error": function(response){
                    console.log(response)
                }
            },
        });

    }
})

