var sideBar = document.createElement("sideBar");
sideBar.innerHTML = `

<!--
Apply the following import to the body to include a Side Navigation Bar in your page:
<script src = "SideBar.js"></script>
-->

<!--Side Bar Body-->
<div class = "offcanvas offcanvas-start" data-bs-scroll = "false" data-bs-backdrop = "true" tabindex = "-1" id = "offcanvasScrolling" aria-labelledby = "offcanvasScrollingLabel">
  
    <div class = "offcanvas-header">

        <div id = "top">

            <div id = "topLeft">

                <!--Profile Picture Icon-->
                <img src = "Assets/ProfilePicture.png" id = "profilePicture" type = "button" data-bs-toggle = "offcanvas" data-bs-target = "#offcanvasScrolling" aria-controls = "offcanvasScrolling" alt = "Profile Picture">
                
                <!--Username and Access Level-->
                <div id = "user">

                    <div id = "username">

                        <p class = "offcanvas-title" id = "offcanvasScrollingLabel"><b>John Cena</b></p>

                    </div>

                    <div id = "userAccess">
              
                        <p class = "offcanvas-title" id = "offcanvasScrollingLabel">Employee</p>
              
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class = "offcanvas-body">

        <div id = "sideBarOptions">

            <ul>

                <!--Settings List-->
                <details open>

                    <summary id = "settings">Settings</summary>

                        <li><button onclick = "#">Setting 1</button></li>
                        <li><button onclick = "#">Setting 2</button></li>

                </details>

                <!--Notifications List-->
                <details open>

                    <summary id = "notifications">Notifications</summary>

                        <li><button onclick = "#">Setting 1</button></li>
                        <li><button onclick = "#">Setting 2</button></li>

                </details>

                <!--Starred Messages List-->
                <details open>

                    <summary id = "starred">Starred Messages</summary>

                        <li><button onclick = "#">Setting 1</button></li>
                        <li><button onclick = "#">Setting 2</button></li>

                </details>

                <!--Dark Mode List-->
                <details open>

                    <summary id = "dark">Dark Mode</summary>

                        <li><button onclick = "#">Setting 1</button></li>
                        <li><button onclick = "#">Setting 2</button></li>

                </details>

            </ul>

        </div>

    </div>

</div>

`;

document.body.appendChild(sideBar);