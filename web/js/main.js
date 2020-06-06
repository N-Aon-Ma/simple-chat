let socket = new WebSocket("ws://localhost:8000");
let name = '';
socket.onopen = function() {
    writeToChatMessage("Соединение установлено");
    socket.send(JSON.stringify({'action' : 'getHistory'}) );
};

socket.onmessage = function(event) {
    let response = JSON.parse(event.data);
    if (response.action && response.action === 'name') {
        document.getElementById('message').placeholder='Введите сообщение...';
        writeToChatMessage(response.message);
    } else if (response.action && response.action === 'chat') {
        writeToChatUserMessage(response.name, response.content);
    } else if (response.action && response.action === 'history' && response.items) {
        response.items.forEach(function(item, i, arr) {
            writeToChatUserMessage(item.name, item.content);
        });
    } else if(response.message){
        writeToChatMessage(response.message);
    }
};

socket.onclose = function() {
    writeToChatMessage('Соединение прервано');
};

socket.onerror = function(error) {
    if (error.message !== undefined) {
        writeToChatMessage(`${error.message}`);
    }
};

function writeToChatMessage(message)
{
    let messageElem = document.createElement('div');
    messageElem.appendChild(document.createTextNode(message));
    document.getElementById('chat').appendChild(messageElem);
    scroll();
}

function writeToChatUserMessage(user, message)
{
    let messageElement = document.createElement('div');
    let messageUserElement = document.createElement('h5');
    let messageContentElement = document.createElement('span');
    messageUserElement.appendChild(document.createTextNode('Имя:' + user));
    messageContentElement.appendChild(document.createTextNode('Текст:' + message));
    messageElement.appendChild(messageUserElement);
    messageElement.appendChild(messageContentElement);
    document.getElementById('chat').appendChild(messageElement);
    scroll();
}

function scroll() {
    let objDiv = document.getElementById("chat");
    objDiv.scrollTop = objDiv.scrollHeight;
}

function sendMessage()
{
    let message = document.getElementById("message").value;
    socket.send(JSON.stringify({'action' : 'sendMessage', 'message' : message}) );
    document.getElementById("message").value = '';
}