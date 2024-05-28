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
                const currentUserID = parseInt(document.body.dataset.userid, 10); // Assuming user ID is stored in a data attribute
                data.forEach(user => {
                    if (user.id !== currentUserID) { // Hide current logged in user
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
                    header.innerHTML = `<span>${msg.sender}</span><span>${msg.timestamp}</span>`;
                    
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

    setInterval(fetchUsers, 5000); // Refresh user list every 5 seconds
    setInterval(fetchMessages, 3000); // Refresh messages every 3 seconds
    fetchUsers(); // Initial fetch
});
