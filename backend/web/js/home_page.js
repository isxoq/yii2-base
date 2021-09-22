var io = null


var app = new Vue({

    el: '#app',
    data: {
        'orders': [],
        'socket': null
    },
    mounted() {
        // this.update_token()
        this.update_orders()


    },
    methods: {

        add_order: function () {

            let phone = this.$refs.new_order_phone.value;
            let address = this.$refs.new_order_address.value;

            if (phone == '' || address == '') {
                return false;
            }

            self = this

            axios.get('/admin/api/add-order', {
                params: {
                    phone: phone,
                    address: address,
                }
            })
                .then(function (response) {

                    if (response.data != false) {
                        self.orders = response.data
                        self.clear_order_inputs()

                        io.send(JSON.stringify({
                            command: "new_order",
                            token: self.token,
                            orders: self.orders
                        }))

                    } else {
                        alert('Xatolik yuz berdi!');
                    }

                })
                .catch(function (error) {
                    console.log(error);
                })

        },

        update_orders: function () {


            self = this
            axios.get('/admin/api/get-orders', {})
                .then(function (response) {
                    Swal.showLoading()
                    self.orders = response.data

                    axios.get('/admin/api/get-token', {})
                        .then(function (response) {
                            self.token = response.data

                            var url = "";
                            if (window.location.protocol == 'https:') {
                                url += "wss://"
                            } else {
                                url += "ws://"
                            }
                            url += window.location.hostname + ":81"
                            console.log(url)

                            io = new WebSocket(url);
                            io.onopen = function (e) {
                                io.send(JSON.stringify({
                                    command: "auth",
                                    token: response.data
                                }))

                                io.send(JSON.stringify({
                                    command: "new_order",
                                    token: self.token,
                                    orders: self.orders
                                }))
                                Swal.hideLoading()
                                Swal.fire({
                                    icon: 'success',
                                    title: 'OK',
                                    text: "Soketga muvaffaqiyatli ulandi!"
                                })
                            };

                            io.onerror = function (e) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: "Soketga ulanishda Xatolik!"
                                })
                                Swal.hideLoading()
                            }

                            io.onmessage = function (e) {

                                var json = JSON.parse(e.data);

                                if (json.success === false) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: json.message
                                    })
                                }
                                console.log('Response:' + e.data);
                            };


                        })


                })
        },

        update_token: function () {

            self = this
            axios.get('/admin/api/get-token', {})
                .then(function (response) {
                    self.token = response.data

                    io = new WebSocket('ws://localhost:81');

                    io.onopen = function (e) {
                        io.send(JSON.stringify({
                            command: "auth",
                            token: response.data
                        }))
                    };

                    io.onmessage = function (e) {

                        var json = JSON.parse(e.data);

                        if (json.success === false) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: json.message
                            })
                        }
                        console.log('Response:' + e.data);
                    };

                })
        },

        clear_order_inputs: function () {
            this.$refs.new_order_phone.value = ''
            this.$refs.new_order_address.value = ''
        }


    }


})