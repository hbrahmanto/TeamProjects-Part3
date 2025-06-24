<!DOCTYPE html>
<head>
    <title>Example</title>
    <!-- import the request script, can be done in top level pages -->
    <script src="Database/DatabaseRequest.js"></script>
</head>
<body>
    <div id="jsonDiv"></div>
    <button id="exampleBtn">Click Me</button>

    <script>

    document.getElementById("exampleBtn").addEventListener("click", function() {

        //preset data as an example
        userID = 12;

        //run after the server call
        function callback(array){
            console.log(array)//received data is printed to the console
            document.getElementById("jsonDiv").innerHTML = JSON.stringify(array);
        }
        //using get in the url fetch
        url = "Database/ExampleFetchServerSide.php" + "?userID=" + userID;
        //make request to server
        DatabaseRequest(url, callback);
        //If the script uses post and not get, then you must use DatabaseRequestPost(url,callback) instead
    });
    </script>

</body>
</html>
