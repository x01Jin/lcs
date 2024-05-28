document.addEventListener('DOMContentLoaded', () => {
    const userList = document.getElementById('users');
    const chatWith = document.getElementById('chat-with');
    const messagesDiv = document.getElementById('messages');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    let selectedUser = null;

    function fetchUsers() {
        fetch('get_users.php')
            .then(response => response.json())
            .then(data => {
                userList.innerHTML = '';
                const currentUserID = parseInt(document.body.dataset.userid, 10);
                data.forEach(user => {
                    if (user.id !== currentUserID && user.role !== 'admin') {
                        const userItem = document.createElement('li');
                        userItem.textContent = user.username + (user.status === 'on' ? ' (Online)' : ' (Offline)');
                        userItem.dataset.userid = user.id;
                        userItem.addEventListener('click', () => {
                            selectedUser = user.id;
                            chatWith.textContent = 'Chat with ' + user.username;
                            fetchMessages();
                        });
                        userList.appendChild(userItem);
                    }
                });
            });
    }

    function fetchMessages() {
        if (!selectedUser) return;
        fetch(`get_messages.php?recid=${selectedUser}`)
            .then(response => response.json())
            .then(data => {
                messagesDiv.innerHTML = '';
                data.forEach(msg => {
                    const messageItem = document.createElement('div');
                    const header = document.createElement('div');
                    const message = document.createElement('div');

                    header.className = 'message-header';
                    header.innerHTML = `<span>${msg.sender.toUpperCase()}</span><span>${msg.timestamp}</span>`;
                    
                    message.className = 'message-content';
                    message.textContent = msg.message;

                    messageItem.appendChild(header);
                    messageItem.appendChild(message);

                    messagesDiv.appendChild(messageItem);
                });
            });
    }

    messageForm.addEventListener('submit', (e) => {
        e.preventDefault();
        if (selectedUser) {
            fetch('send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ recid: selectedUser, message: messageInput.value })
            }).then(() => {
                messageInput.value = '';
                fetchMessages();
            });
        }
    });

    setInterval(fetchUsers, 5000);
    setInterval(fetchMessages, 3000);
    fetchUsers();
});
