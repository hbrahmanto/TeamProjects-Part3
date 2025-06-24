<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chat System</title>
        <link rel="stylesheet" href="style.css">
        <script>
            // Simple JavaScript function for tab switching
            function switchTab(tabName) {
                const tabs = document.querySelectorAll('.tab-content');
                tabs.forEach(tab => {
                    tab.style.display = 'none';
                });
                document.getElementById(`${tabName}-container`).style.display = 'block';
            }
        </script>
    </head>

    <body>
        <!-- Bottom Navigation Bar -->
        <div id="bottomNavBar">
            <button onclick="loadPrivateChats()">Private Chats</button>
            <button onclick="loadGroupChats()">Group Chats</button>
            <button onclick="switchTab('messages-chat')">Message</button>
        </div>
    </body>
</html>
