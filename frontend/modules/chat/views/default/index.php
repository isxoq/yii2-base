<?php

/** @var $this \soft\web\View */

use frontend\assets\VueAsset;

$this->title = 'Real time chat by Odilov';

//VueAsset::register($this);

//$this->registerJsFile('/js/axios/axios.min.js');

?>

<div id="main">
    <h1><?= $this->title ?></h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="name" placeholder="Your name here">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="msg" placeholder="Your message here">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" v-on:click=send>Send</button>
                        Type <span class="text-dabger">/reset</span> to reset all messages
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Chat
                </div>

                <div class="card-body">
                    <ul v-for='m in msgA'>
                        <li>
                            <span class="badge badge-primary">{{ m.name }}</span> - {{ m.msg }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/axios/axios.min.js"></script>
<script src="/vue/vue.js"></script>
<script>

    var conn = new WebSocket('ws://localhost:8080');

    var app = new Vue({

        'el': '#main',
        'data': {
            'msg': 'Test message',
            'name': '',
            'conn': '',
            'msgA': [
                {"name": "Name", "msg": "test message"}
            ]
        },

        mounted() {
            this.get();
            self = this
            conn.onopen = (e) => {
                this.msg = 'has connected'
                this.send()
            };

            conn.onmessage = (e) => {
                self.rcv(e.data)
            }
        },

        methods: {

            get: function () {

                console.log('get function called')

                self = this
                axios.get('/chat/default/get-messages')
                    .then(function (response) {
                        self.msgA = response.data
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },

            send: function () {
                console.log('send function called')

                var sendObj = {
                    'name': this.name,
                    'msg': this.msg
                }
                var msgString = JSON.stringify(sendObj)
                conn.send(msgString)
                this.msg = '';
                this.get()
            },

            rcv: function (str) {
                console.log('rcv function called')
                this.get()
            }
        }

    })


</script>

<?php

$js = <<<JS



    var conn = new WebSocket('ws://localhost:8080');

    var app = new Vue({

        'el': '#main',
        'data': {
            'msg': 'Test message',
            'name': '',
            'conn': '',
            'msgA': [
                {"name" : "Name", "msg" : "test message"}
            ]
        },

        mounted() {
            this.get();
            self = this
            conn.onopen = (e) => {
                self.rcv()
            };

            conn.onmessage = (e) => {
                self.rcv(e.data)
            }
        },

        methods: {

            get: function () {
    
                self = this
                axios.get('/chat/default/get-messages')
                    .then(function (response) {
                        this.msgA = response.data
                        console.log(this.msgA)
                    })
                    .catch(function (error) {
                        console.log(error)
                    })

            },

            send: function () {
                var sendObj = {
                    'name': this.name,
                    'msg' : this.msg
                }
                var msgString = JSON.stringify(sendObj)
                conn.send(msgString)
                this.rcv()
            },
            
            rcv: function (str){
                this.get()
            }
        }

    })




    

JS;
//$this->registerJs($js, \yii\web\View::POS_END);

?>

