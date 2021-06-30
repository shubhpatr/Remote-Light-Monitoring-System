<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Shoodi</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .center-logo {
                position: absolute;
                right: 5px;
                top: 18px;
            }
            .content {
                text-align: center;
                
            }

            .content2 {
                text-align: center;
                color:  #F60419;
                
            }
            .button {
                color: blue;
                font-size: 16px;
                
                background-color: white;
                transition-duration: 0.4s;
                cursor: pointer;
 
             border: 2px solid #F60419;
            }
            .button:hover {
  background-color: #e3eaee; /* Green */
               
  box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}

            .title {
                font-size: 84px;
            }
            .title2 {
                font-size: 84px;
                color: black;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .link > a {
                
                padding: 25px;
               
                font-size: 48px;
                font-family: 'Nunito', sans-serif;
                font-weight: thin;
                letter-spacing: .1rem;
                text-decoration: none;
                
     
            }

            .m-b-md {
                margin-bottom: 50px;
                padding: 12px;
            }
            .wrapper {
                display: flex;
              
                
            }
        </style>
    </head>
    <body>
        <div class="flex-center ">
          
               
                </div>
              

    

                
                <div class="flex-center">
                <div class="title m-b-md">
                Welcome to
                </div>
                <div class="title2 m-b-md">
                Shoodi  
                </div>
                <div class="content2" >
                
                <div class="title m-b-md">
                Ecosystem.
                </div>
                </div>
                </div>
            <div class="flex-center m-b-md" style="font-size: 50px">
            <button  class="link button" style="margin-right: 16px ;">
                  
                        <a href="{{ route('login') }}" >Click here</a>
                       
                </button>
            to enter your automation world!
            
            </div>
      </div>      
       
    </body>
</html>
