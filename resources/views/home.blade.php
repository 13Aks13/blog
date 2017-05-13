<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        .modal-mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .5);
            display: table;
            transition: opacity .3s ease;
        }

        .modal-wrapper {
            display: table-cell;
            vertical-align: middle;
        }

        .modal-container {
            width: 300px;
            margin: 0px auto;
            padding: 20px 30px;
            background-color: #fff;
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
            transition: all .3s ease;
            font-family: Helvetica, Arial, sans-serif;
        }

        .modal-header h3 {
            margin-top: 0;
            color: #42b983;
        }

        .modal-body {
            margin: 20px 0;
        }

        .modal-default-button {
            float: right;
        }

        /*
         * The following styles are auto-applied to elements with
         * transition="modal" when their visibility is toggled
         * by Vue.js.
         *
         * You can easily play with the modal transition by editing
         * these styles.
         */

        .modal-enter {
            opacity: 0;
        }

        .modal-leave-active {
            opacity: 0;
        }

        .modal-enter .modal-container,
        .modal-leave-active .modal-container {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
    </style>

    <title>Document</title>

    <script src="https://unpkg.com/vue/dist/vue.js"></script>

</head>
<body>

<!-- template for the modal component -->
<script type="text/x-template" id="modal-template">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-header">
                        <slot name="header">
                            default header
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            default body
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            default footer
                            <button class="default-button" @save="$emit('save')">Save</button>
                            <button class="modal-default-button" @click="$emit('close')">Close</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</script>

<!-- app -->
<div id="app" class="container">
    <button id="show-modal" @click="showModal = true">Show Modal</button>
    <!-- use the modal component, pass in the prop -->
    <modal v-if="showModal" @close="showModal = false">
    <!--
        you can use custom content here to overwrite
        default content
    -->
        <h3 slot="header">Meal edit</h3>

        <div slot="body">
                <span>Title</span>
                <input v-model="title" name="Title"><br>

                <span>Tags</span>
                <input v-model="tags" name="Tags"><br>

                <span>Event Id</span>
                <select v-model="selected" name="Event Id"></select><br>

                <span>Body</span>
                <input v-model="body" name="Body"><br>

                <span>Price</span>
                <input v-model="price" name="Price"><br>

                <span>User Id</span>
                <select v-model="selected" name="User Id"></select><br>

                <span>Action</span>
                <input v-model="action" name="Action"><br>
        </div>

    </modal>
</div>

<script>
    Vue.component('modal', {
        template: '#modal-template'
    })


    new Vue({
        el: '#app',
        data: {

            showModal: false,
            title:  'Title',
            tags: 'Tag',
            eventid: '',
            body: 'Body',
            price: '0.00',
            userid: '',
            action:  'Action'

        }
    })
</script>

</body>
</html>