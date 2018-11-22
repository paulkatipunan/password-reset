<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/cms.css">
    <style>
      body {font-family: Arial, Helvetica, sans-serif;}

      input[type=email], input[type=password] {
          width: 100%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
      }

      button {
          background-color: #4CAF50;
          color: white;
          padding: 14px 20px;
          margin: 8px 0;
          border: none;
          cursor: pointer;
          width: 100%;
      }

      button:hover {
          opacity: 0.8;
      }

      .cancelbtn {
          width: auto;
          padding: 10px 18px;
          background-color: #f44336;
      }

      .imgcontainer {
          text-align: center;
          margin: 24px 0 12px 0;
      }

      img.avatar {
          width: 40%;
          border-radius: 50%;
      }

      .container {
          padding: 16px;
      }
      .centered {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transform: -webkit-translate(-50%, -50%);
        transform: -moz-translate(-50%, -50%);
        transform: -ms-translate(-50%, -50%);
        color: white;
        font-size: 20px;
        z-index: 1;
      }
      span.psw {
          float: right;
          padding-top: 16px;
      }

      /* Change styles for span and cancel button on extra small screens */
      @media screen and (max-width: 300px) {
          span.psw {
             display: block;
             float: none;
          }
          .cancelbtn {
             width: 100%;
          }
      }
    </style>
  </head>
    <body class="body-login">
        <div class="content container login-container" style="width: 400px;margin: auto">
            <i v-show="spinner" class="fa fa-spinner fa-spin centered" style="color: black;"></i>
            <div class="login-brand">
                <img class="login-logo" src="{{ URL::to('/') }}/images/cms-logo-lg.png">
            </div>

            <!-- <form method="POST" action="{{ route('update.password') }}">
                @csrf -->
                
                <input id="token" type="hidden" name="token" value="{{ $passwordReset->token }}">
                <h4 v-if="!message" class="text-danger" style="color: red">@{{error}}</h4>
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $passwordReset->email }}" required readonly="readonly">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required autofocus v-model="password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required v-model="password_confirmation">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button id="submitBtn" type="submit" class="btn btn-primary" @click="submit">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
            <!-- </form> -->
        </div>

        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="{{url('/js/axios.js')}}"></script>
        <script>

        var vue = new Vue({
            el: '.content',
            mounted() {

               

            },
            data: {

                email:'',
                password:'',
                password_confirmation:'',
                success:'',
                error:'',
                spinner:'',
                message: false,
                
            },
            methods: {
                submit(){

                    this.spinner = true;
                    $('#submitBtn').attr("disabled", true);
                    axios.post("{{ route('update.password') }}",{ 

                        email: document.getElementById('email').value,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                        token: document.getElementById('token').value,

                    })
                    .then((response) => {
                        console.log(response)
                        alert(response.data);
                        window.location.href = "{{ URL::previous() }}";
                        
                    }).catch(error => {
                        var err = '';
                        console.log(error.response.data)
                        err = error.response.data;
                        this.error = err.message;
                        this.message = false;
                        this.spinner = false;
                        $('#submitBtn').attr("disabled", false);
                    });

                }
                
            },


        });
        </script>
    </body>
</html>

