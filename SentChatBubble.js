var sentChatBubble = document.createElement("sentChatBubble");
//an example of a send chat bubble
sentChatBubble.innerHTML = `

<!--
Apply the following import to the body to include a Sent Chat Bubble in your page:
<script src = "SentChatBubble.js"></script>
-->

<!--
!!READ ME!! This component cannot be imported inside of a div as far as I am aware. It will be 
loaded globally. As such, I have included the 'chatSystem' and 'chatWindow' divs in this file 
until a solution can be found as they are needed for the CSS. 
Ideally, these two divs would be located in the HTML/PHP file.
-->

<div id = chatSystem>

    <div id = chatWindow>

        <div class = sentChatBubbleExt>

            <div class = "sentChatBubble">

                <div class = "chatMessage">

                    Glad you're doing well, definitely just let me know when you're free!
                
                    <div class ="sentTime">

                        05:24pm

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
        
`;

//document.body.appendChild(sentChatBubble);

//creates a sent chatbubble and appends it to the given chatDiv
//invlude sendername puts the name on the message, use in group chats
//message id stored in chatbubble.value
function createSentChatBubble(chatDiv, messageContents, sendTime, messageID, includeSenderName = false, senderName = ""){

    var sendTimeDiv = document.createElement("div");
    sendTimeDiv.className = "sentTime";
    sendTimeDiv.textContent = sendTime;

    var chatMessage = document.createElement("div");
    chatMessage.className = "chatMessage";
    chatMessage.textContent = messageContents;
    chatMessage.appendChild(sendTimeDiv);

    if (includeSenderName){
        var sendNameDiv = document.createElement("div");
        sendNameDiv.className = "sentTime sentName";
        sendNameDiv.textContent = senderName;
        chatMessage.appendChild(sendNameDiv)
    }

    var chatBubble = document.createElement("div");
    chatBubble.className = "sentChatBubble";
    chatBubble.value = messageID;
    chatBubble.appendChild(chatMessage);

    var chatBubbleExt = document.createElement("div");
    chatBubbleExt.className = "sentChatBubbleExt";
    chatBubbleExt.appendChild(chatBubble);

    chatDiv.appendChild(chatBubbleExt);
}