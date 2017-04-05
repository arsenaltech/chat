<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        <ul>
                            <li v-for="msg in messages">
                                {{msg}}
                            </li>
                        </ul>
                        <form @submit.prevent="sendMessage">
                            <input type="text" v-model="message"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    mounted() {

      Echo.private('App.User.'+Laravel.user_id)
        .listen("NewMessage", (e) => {
          this.messages.push(e.message);
        });


    },
    data() {
      return {
        message: '',
        messages: []
      }
    },
    methods: {
      sendMessage() {
        axios.post('/chat', {message: this.message});
        this.message = '';
      }
    }
  }
</script>
