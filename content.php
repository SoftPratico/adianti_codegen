<?php


function headerContent($dir = "/")
{
    echo "<!DOCTYPE html>
                <html>
                <head>
                    <meta charset=\"utf-8\">
                    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
                    <title>ADIANTI Code Generator</title>
                    <!-- Application custom CSS -->
                    <!-- Bootstrap -->
                     
                    <link href=\"https://use.fontawesome.com/releases/v5.0.4/css/all.css\" rel=\"stylesheet\">
                 
                     <!--Import Google Icon Font-->
                      <link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">
                      <!--Import materialize.css-->
                      <link type=\"text/css\" rel=\"stylesheet\" href=\"{$dir}lib/materialize/css/materialize.min.css\"  media=\"screen,projection\"/>
                             <!--Let browser know website is optimized for mobile-->
                      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>
       
                    <style>
                    .icon_style{
                        position: absolute;
                        right: 10px;
                        top: 10px;
                        font-size: 20px;
                        color: white;
                        cursor:pointer; 
                    }
                                    
                      /* label focus color */
                     .input-field input:focus + label {
                       color: #0091ea !important;
                     }
                      /* label underline focus color */
                     .row .input-field input:focus {
                        border-bottom: 1px solid #0091ea !important;
                        box-shadow: 0 1px 0 0 #0091ea !important
                      }
                      [type=\"radio\"]:checked + label:after,
                      [type=\"radio\"].with-gap:checked + label:after {
                          border: 2px solid #0277bd;
                          background-color: #0277bd;
                          z-index: 0;
                      }
                      [type=\"checkbox\"]:checked + label:after,
                      [type=\"checkbox\"].filled-in:checked + label:after  {
                          border: 2px solid #0277bd !important;
                          background-color: #0277bd;
                          z-index: 0;
                       }
                    </style>
                </head>
                
                <body>
                     <nav class=\"#1976d2 blue darken-2\" style=\"height: 100px\" role=\"navigation\">
                        <div class=\"nav-wrapper container\">
                          <a href=\"#\" class=\"brand-logo\" style=\"margin: 20px 0px 20px 0px;\"> <h5>ADIANTI <small> CODE Generator</small></h5></a>
                        </div>
                      </nav>
                    <div class=\"row\">
                ";
}

function footerContent($dir = "/")
{
    echo "<!-- end content -->
              <!--Import jQuery before materialize.js-->
              <script type=\"text/javascript\" src=\"https://code.jquery.com/jquery-3.2.1.min.js\"></script>
                     <!-- jQuery (necessary for Bootstrap's JavaScript plugins)
             <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script> -->
       
              <script type=\"text/javascript\" src=\"{$dir}lib/materialize/js/materialize.min.js\"></script>
              
              <!--Import jQuery Init Template-->
              <script type=\"text/javascript\" src=\"{$dir}lib/materialize/js/init.js\"></script>
    
        </div><!-- and row content --> 
         <footer class=\"page-footer #e6e6e6 grey lighten-3\" style=\"margin-top: 12%;\">
          <div class=\"footer-copyright #d8d8d8 grey lighten-2\">
            <div class=\"container\">
            <b style=\"color: black\">" . date('Y') . "</b> 
            <a class=\"black-text text-lighten-4 right\" href=\"#!\"><b>Dev</b> </a>
            </div>
          </div>
        </footer>
    </body>
    </html>";
}

function breadcrumb($step = 1)
{

    $nav = ' <nav class="#9e9e9e grey">
    <div class="nav-wrapper">
      <div class="col s12" style="margin: auto 190px;">';

    for ($i = 1; $i <= 4; $i++) {
        if ($step == $i) {
            $nav .= '<a  class="breadcrumb" href = "step0' . $i . '.php" ><b style="color:white"> Etapa 0' . $i . ' </b></a ></li > ';
        } else {
            $nav .= '<a  class="breadcrumb" href = "step0' . $i . '.php" > Etapa 0' . $i . ' </a ></li > ';
        }
    }
    if ($step == 5) {
        $nav .= '<a  class="breadcrumb" href = "step05.php" ><b style="color:white;"> Final</a ></b>';
    } else {
        $nav .= '<a  class="breadcrumb" href = "step05.php" style="color: rgba(255, 255, 255, 0.7);">Final</a >';
    }
    $nav .= '</div>
            </div>
          </nav>';
    echo $nav;
}