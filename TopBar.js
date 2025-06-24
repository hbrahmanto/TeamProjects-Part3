var topBar = document.createElement("topBar");
topBar.innerHTML = `

<!--
Apply the following import to the body to include a Top Navigation Bar in your page:
<script src = "TopBar.js"></script>
-->

<div id = "top">

    <div id = "topLeft">

        <!--Profile Picture Icon-->
        <img src = "Assets/ProfilePicture.png" id = "profilePicture" type = "button" data-bs-toggle = "offcanvas" data-bs-target = "#offcanvasScrolling" aria-controls = "offcanvasScrolling" alt = "Profile Picture">
        
        <!--Username and Access Level-->
        <div id = "user">

            <div id = "username" style = "padding-bottom: 0px; margin-bottom: 0px;">

                <p id="topbar-user-name"><b>John Cena</b></p>

            </div>

            <div id = "userAccess"padding-top: 0px; margin-top: 0px;>
            
                
            
            </div>

        </div>

    </div>

    <!--Logo-->
    <div id = topCenter>

        <img src = "Assets/Logo.png" id = "logo" alt = "Logo">

    </div>



</div>

`;

document.body.appendChild(topBar);