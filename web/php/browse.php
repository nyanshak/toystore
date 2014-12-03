<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
 
        <title>Browse Toy Store</title>
        <link rel="stylesheet" href="/css/styles.css" type="text/css" />
        <link rel="stylesheet" href="/css/navbar.css" type="text/css" />
        <link rel="stylesheet" href="//yui.yahooapis.com/pure/0.5.0/pure-min.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="/js/browse.js"></script>
        <script src="/js/navbar.js"></script>
        <script src="/js/leftsidebar.js"></script>
    </head>
    <body>
        <div id="Wrap">
            <?php
				$_SESSION["Url"] = "/php/browse.php";
                define('INCL_HEADER_CONST', TRUE);
                ob_start();
                include('header.php');
                $result = ob_get_clean();
                echo $result;
            ?>
            <div id="LeftSidebar">
            </div> <!-- end "LeftSidebar" -->
            <div id="MainContent">
                <br />
                <div id="browse" class="pure-form">
                    <span>Category: </span>
                    <select id="catfilter">
                        <option></option>
                    </select>
                    <span>        </span>
                    <input type="text" id="search" />
                    <button id="searchBtn" class="pure-button">Search</button>
                </div>
                <br />
                <table id="products" class="browse"></table>
            </div>
        </div>
    </body>
</html>

