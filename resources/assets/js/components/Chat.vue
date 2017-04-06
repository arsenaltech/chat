<template>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="list-group">
          <template v-for="user in onlineExceptMe">
          <a href="#"
             :class="{'list-group-item': true, 'active': (to.id == user.id)}"
             @click="selectTo(user)"
          >
            {{user.name}}
          </a>
          </template>

        </div>
      </div>
      <div class="col-md-8">
        <div class="panel panel-default">

            <div class="media" v-for="message in currentUserMessages">
              <template v-if="message.from.id != loggedInUser.id">
              <div class="media-left"><a href="#"> <img alt="64x64" class="media-object"
                                                        src="https://placeholdit.imgix.net/~text?&txt=64x64&w=64&h=64"
                                                        data-holder-rendered="true"> </a></div>
              <div class="media-body"><h4 class="media-heading">{{message.from.name}}</h4>
                {{message.message}}
              </div>
              </template>

              <template v-else>
                <div class="media-body text-right"><h4 class="media-heading">{{message.from.name}}</h4>
                  {{message.message}}
                </div>
                <div class="media-right"><a href="#"> <img alt="64x64" class="media-object"
                                                          src="https://placeholdit.imgix.net/~text?&txt=64x64&w=64&h=64"
                                                          data-holder-rendered="true"> </a></div>

              </template>
            </div>




        </div>
        <div>
          <form  @submit.prevent="sendMessage">
            <div class="form-group">
              <input type="text" v-model="message" class="form-control"/>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</template>

<script>

  export default {
    mounted() {
      //this.getUsers();
      Echo.join('chat-room-presence' )
        .here((members) => {

          this.onlineUsers = members;
          this.to = this.onlineExceptMe[0];

      })
        .joining((joiningMember) => {
          this.onlineUsers.push(joiningMember);

      })
        .leaving((leavingMember) => {
          this.onlineUsers = this.onlineUsers.filter((user) => (user.id != leavingMember.id))
        });
      Echo.private('App.User.' + Laravel.user.id)
        .listen("NewMessage", (e) => {
          this.messages.push(e);
        });


    },
    data() {
      return {
        users: [],
        onlineUsers: [],
        message: '',
        messages: [],
        to: null
      }
    },
    computed: {
      currentUserMessages() {
        return this.messages.filter((message) => (
          message.from.id == this.to.id ||
          (message.from.id == Laravel.user.id && message.to.id == this.to.id)
        ));
      },
      loggedInUser() {
        return Laravel.user;
      },
      onlineExceptMe() {
        return this.onlineUsers.filter((user)=> (user.id != this.loggedInUser.id))
      }

    },
    methods: {

      selectTo(user) {
        this.to = user;
      },

      sendMessage() {
        this.messages.push({
          from: Laravel.user,
          to: this.to,
          message: this.message
        });
        axios.post('/chat', {message: this.message, to: this.to.id});
        this.message = '';
      }
    }
  }
</script>

<style>
  html, body {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
  }

  #Chat {
    width: 100%;
    height: 100%;
  }

  #Chat__Login {
    display: flex;
    align-items: center;
    align-content: center;
    width: 100%;
    height: 100%;
  }

  #Chat__Login form {
    width: 100%;
    text-align: center;
  }

  #Chat__Login input {
    margin: 0 auto;
    font-size: 2em;
    -webkit-appearance: none;
    padding: 10px;
    border: 2px solid #eee;
  }

  #Chat__Login input:focus {
    outline: none;
    background: #eee;
  }
</style>