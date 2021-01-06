<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Not Found</title>
    <style>
      /*use 404 page not found css*/
      body {
          margin: 0;
      }
      .error-page {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        height: 100%;
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        padding: 40px;
        
      }
​
      .error-page h1 {
        font-size: 35vh;
        font-weight: bold;
        position: relative;
        margin: -8vh 0 0;
        padding: 0;
      }
​
      .error-page h1 {
        color: #127ce5;
        /* webkit only for graceful degradation to IE */
​
​
      }
​
      .error-page h1+p {
        color: #827ca1;
        font-size: 8vh;
        font-weight: bold;
        line-height: 10vh;
        max-width: 600px;
        position: relative;
        margin: 0;
      }
​
      .error-page h1+p:after {
        content: attr(data-p);
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        color: transparent;
        text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
        -webkit-background-clip: text;
        -moz-background-clip: text;
        background-clip: text;
      }
​
      .cstm-text-black {
        color: #000;
      }
​
      .error-page .cstm-bottom-text {
        color: #827ca1;
        font-size: 18px;
​
      }
      .error_header {
        background-color: #fff;
        border-bottom: 1px solid #e7e7ef;
        padding: 0.5rem 1rem;
      }
      .error_header img {
          width: 250px;
      }
      .error_header a {
          display: block;
      }
      .logo_error {
          padding: 8px 0;
      }  
      .error_footer {
          padding: 15px;
          background-color: #fafafb;
          border-top: 1px solid #ccc;
          text-align: center;
          font-size: 13px;
          font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
      }
      .error_footer p {
          margin: 0;
      }
      .error_main {
        min-height: calc(100vh - 70px);
      }
      a:hover {
        color: #0056b3;
        text-decoration: none !important;
        outline: none;
      }
      /*end*/
    </style>
  </head>
    <body>
        @include('includes.header')
        <main class="error_main">
            <div class="error-page">
                <div>
                    <h1 data-h1="404">4<span class="cstm-text-black">0</span>1</h1>
                    <p data-p="NOT FOUND">Unauthorized URL</p>
                    <p class="cstm-bottom-text">The requested URL was not found on this server.</p>
                    Please try again later or go to <a class="button" href="/login"><i class="icon-home"></i> Login Page </a>
                </div>
            </div>
        </main>
        @include('includes.footer')
    </body>
</html>