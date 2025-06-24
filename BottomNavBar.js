var bottomNavBar = document.createElement("bottomBar");
bottomNavBar.innerHTML = `
<div id="bottomNavBar" style="position: fixed; bottom: 0; width: 100%; background-color: #f8f9fa; border-top: 1px solid #dee2e6; padding: 10px 0; text-align: center;">
  <button id='homebutton' onclick='switchTab("private-chat")'>Private Chats</button>
  <button id='personalchats' onclick="switchTab('group-chat')">Group Chats</button>
  <button id='groupchat' onclick="switchTab('messages-chat')">Chat</button>
</div>
`;
document.body.appendChild(bottomNavBar);

getElementById('homebutton').addEventListener('click', getChats);

function getChats(){
  userID = 12;

  //run after the server call
  function callback(array){
    console.log(array)//received data is printed to the console
    array.forEach(chat => {
      chatdivs = document.getElementById('chatsdiv');
      button = document.createElement('button');
      button.innerHTML = chat['ChatID'];
      chatdivs.appendChild(button);
    });
  }
  //using get in the url fetch
  url = "Database/FetchChatsFromUser.php" + "?userID=" + userID;
  //make request to server
  DatabaseRequest(url, callback);
}

function switchTab(tabName) {
  const tabs = document.querySelectorAll('.tab-content');
  tabs.forEach(tab => {
      tab.style.display = 'none';
  });
  document.getElementById(`${tabName}-container`).style.display = 'block';
}