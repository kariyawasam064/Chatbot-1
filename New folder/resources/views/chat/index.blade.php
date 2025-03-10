<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
</head>
<body>
    <div class="top-bar d-flex align-items-center justify-content-between px-3 py-2">
        <div class="logo">
            <img src="{{ asset('assets/Logo.png') }}" alt="SLT Logo" height="40">
        </div>
        <div class="search-bar d-flex flex-grow-1 mx-3">
            <input type="text" id="search-input" class="form-control me-2" placeholder="Search contacts, messages, or options here...">

        </div>
        <div class="user-info d-flex align-items-center">
            <span class="me-2"><b>{{ $agentName }}</b></span>
            <img src="{{ asset('assets/icon_green.jpeg') }}" alt="User Image" class="rounded-circle">
        </div>
    </div>

        <div class="row">
            <!-- Sidebar -->
            <div class="option-sidebar">
                <div class="icon-option">
                    <a href="{{ route('agent.chat') }}">
                        <i class="bi bi-chat-dots text-white"></i>
                    </a>
                </div>
                <div class="icon-option">
                    <i class="bi bi-gear"></i>
                </div>
                <div class="icon-option">
                    <i class="bi bi-person"></i>
                </div>
                <div class="icon-option">
                    <form action="{{ route('logout') }}" method="POST" class="icon-option d-inline">
                        @csrf
                        <button type="submit" class="btn">
                            <i class="bi bi-box-arrow-right text-white"></i>
                        </button>
                    </form>
                </div>
            </div>
    
            <!-- Contact List -->
            <div class="col-md-3 contact-sidebar">
                <div class="d-flex align-items-center p-3" style="background-color: #2e3a84;">
                    <img src="#" alt="" class="me-2">
                    <span>Contacts</span>
                </div>
                <ul id="contacts" class="contact-list">
                    @forelse($contacts as $contact)
                        <li class="contact-item" data-phone="{{ $contact->phone_number }}">
                            <img src="{{ asset('assets/human_icon1.jpeg') }}" alt="">
                            <span>{{ $contact->phone_number }}</span>
                            <span class="unread-count" style="display: none;"></span> <!-- Unread count -->
                        </li>
                    @empty
                        <li>No contacts available</li>
                    @endforelse
                </ul>
            </div>
    
            <!-- Chat Box -->
            <div class="col-md-8 chat-section">
                <div id="contact-info" class="contact-info">
                    <img src="{{ asset('assets/human_icon1.jpeg') }}" alt="">
                    <span>Select a contact to start chatting</span>
                </div>
    
                <div id="chat-box" class="chat-box">

                    
                </div>
                <div id="predefined-message-dropdown" class="dropdown-menu">
                    <a class="dropdown-item" href="#">Hello! 👋 I'm {{ $agentName }}.Thank you for reaching with us!.How can we assist you today?</a>
                    <a class="dropdown-item" href="#">Please hold on for a moment while I look into this for you. Thank you!</a>
                    <a class="dropdown-item" href="#">Thank you for reaching out to us! 😊 If you have any more questions in the future, feel free to reach out. Have a great day! 👋</a>
                    <a class="dropdown-item" href="#">ආයුබෝවන්! 👋 මම {{ $agentName }}.අප හා සම්බන්ධ වීම ගැන ඔබට ස්තුතියි!. අද ඔබට අපි කෙසේ සහාය දිය හැකිද?</a>
                    <a class="dropdown-item" href="#">මම ඔබ වෙනුවෙන් මෙය පරීක්ෂා කරන තෙක් කරුණාකර රැඳී සිටින්න. ඔබට ස්තූතියි!</a>
                    <a class="dropdown-item" href="#">අප හා සම්බන්ධ වීම ගැන ඔබට ස්තුතියි! 😊. සුබ දවසක්! 👋</a>
                    <a class="dropdown-item" href="#">வணக்கம்! 👋 நான் {{ $agentName }}. இன்று நாம் உங்களுக்கு எவ்வாறு உதவலாம்?</a>
                    <a class="dropdown-item" href="#">தயவு செய்து ஒரு क्षணம் காத்திருக்கவும், நான் இதை உங்களுக்கு பரிசோதிக்கின்றேன். நன்றி!</a>
                    <a class="dropdown-item" href="#">எங்களை தொடர்புகொண்டதற்கு நன்றி! 😊 உங்களுக்கு ஒரு நல்ல நாள் இருக்கட்டும்! 👋</a>
                </div>
    
                
                <form id="chat-form" class="message-input-group">
                    <button type="button" class="btn btn-outline-secondary me-2" id="predefined-message-btn">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <input type="text" id="message" class="form-control" placeholder="Type a message">
    <div class="custom-file-upload d-flex align-items-center gap-2">
        <label for="document" class="btn btn-outline-primary d-flex align-items-center">
            <i class="bi bi-paperclip"></i> Attach File
        </label>
        <input type="file" id="document" name="document" accept=".pdf,.xlsx,.xls,.jpg,.jpeg,.png,.gif,.webp"  class="d-none">
        <span id="file-name" class="text-muted small">No file chosen</span>
    </div>
                    <button type="submit">
                        <i class="bi bi-send"></i> Send
                    </button>
                </form>
            </div>
        </div>
    
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        
<script>
document.addEventListener('DOMContentLoaded', () => {
    const emp_id = '{{ $emp_id }}';
    const contacts = @json($contacts);
    const chatBox = document.getElementById('chat-box');
    const messageForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message');
    const predefinedMessageBtn = document.getElementById('predefined-message-btn');
    const predefinedMessageDropdown = document.getElementById('predefined-message-dropdown');
    const contactInfo = document.getElementById('contact-info');
    const contactList = document.getElementById('contacts');
    // let currentContact = '';



    predefinedMessageBtn.addEventListener('click', () => {
        predefinedMessageDropdown.classList.toggle('show');
    });

    predefinedMessageDropdown.addEventListener('click', (e) => {
        const message = e.target.textContent;
        if (message) {
            messageInput.value = message; // Populate input with selected message
            predefinedMessageDropdown.classList.remove('show'); 
        }
    });

   
// Save the updated order of contacts to localStorage
function saveContactOrder() {
    const contactItems = document.querySelectorAll('.contact-item');
    const contactOrder = Array.from(contactItems).map(contact => contact.getAttribute('data-phone'));
    localStorage.setItem('contactOrder', JSON.stringify(contactOrder)); // Save to localStorage
}


function moveContactToTop(phoneNumber) {
    const contactList = document.querySelector('.contact-list');
    const contactItem = document.querySelector(`.contact-item[data-phone="${phoneNumber}"]`);
    
    if (contactItem && contactList) {
        contactList.prepend(contactItem);
    }
}


// Load messages for a specific contact
function loadMessages(phoneNumber) {
    axios.get(`/messages/${phoneNumber}`)
        .then(response => {
            chatBox.innerHTML = '';
            response.data.forEach(msg => {
                appendMessage(msg, msg.from === emp_id);
            });

            // Set lastMessageTime to the timestamp of the most recent message
            if (response.data.length > 0) {
                lastMessageTime = response.data[response.data.length - 1].timestamp; // Assuming 'timestamp' is in the message data
            }

            
        })
        .catch(error => console.error("Error loading messages!", error));
}

    function updateContactInfo(phoneNumber) {
        contactInfo.innerHTML = `<img src="{{ asset('assets/human_icon1.jpeg') }}" alt=""> ${phoneNumber}`;
    }

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    document.addEventListener('DOMContentLoaded', function () {
    const savedOrder = JSON.parse(localStorage.getItem('contactOrder'));

    if (savedOrder) {
        savedOrder.forEach(phoneNumber => {
            const contact = document.querySelector(`.contact-item[data-phone="${phoneNumber}"]`);
            if (contact) {
                contactList.appendChild(contact); // Append in the saved order
            }
        });
    }
      
    });

    // Optimize contact selection with event delegation
    contactList.addEventListener('click', function (e) {
    const contact = e.target.closest('.contact-item');
    if (contact) {
        const phoneNumber = contact.getAttribute('data-phone');
        localStorage.setItem('lastActiveChat', phoneNumber);
        currentContact = phoneNumber;
        updateContactInfo(currentContact);
        loadMessages(currentContact);
        // subscribeToChannel(currentContact);
       
        // Remove the unread count when contact is clicked
        const unreadBadge = contact.querySelector('.unread-count');
        if (unreadBadge) {
            unreadBadge.style.display = 'none';
        }

        openChats(phoneNumber);
        
    }
});


let lastMessageTime = 0;
let sentMessageIds = new Set();
let currentContact = null;

// Load last active chat from localStorage
let activeChat = localStorage.getItem('active_chat');
    if (activeChat) {
        openChat(activeChat);
    }

    // Function to update active chat UI
    function updateActiveChatUI(phoneNumber) {
        document.querySelectorAll('.contact-item').forEach(contact => {
            contact.classList.remove('active-chat');
        });

        const activeContact = document.querySelector(`.contact-item[data-phone="${phoneNumber}"]`);
        if (activeContact) {
            activeContact.classList.add('active-chat');
        }
    }

function appendMessage(data, isSent) {
    // console.log("Received message data:", data);

    sentMessageIds.add(data.id);

    const messageDiv = document.createElement('div');
    messageDiv.className = 'message ' + (isSent ? 'sent' : 'received');
    messageDiv.dataset.id = data.id;

    let messageContent = `<div>${data.message}</div>`;


    if (data.document_id) {
        const viewUrl = `/document/view/${data.document_id}`;
        const documentUrl = `/document/${data.document_id}`;

        messageContent += `
            <div class="document-links">
    <a href="${viewUrl}" target="_blank" class="btn btn-primary text-white shadow-sm px-3">
        📄 View Document
    </a>
    <a href="${documentUrl}" download class="btn btn-primary text-white shadow-sm px-3">
        ⬇️ Download
    </a>
</div>

        `;
    } else {
        // console.log("No document ID found in message.");
    }

    messageContent += `<small class="text-muted"> ${data.formatted_time}</small>`;

    messageDiv.innerHTML = messageContent;
    chatBox.appendChild(messageDiv);
    scrollToBottom();
}

document.getElementById('document').addEventListener('change', function() {
    const fileName = this.files.length > 0 ? this.files[0].name : "No file chosen";
    document.getElementById('file-name').textContent = fileName;
});

function openChat(contactId) {
    currentContact = contactId;

    sentMessageIds.clear();
    lastMessageTime = 0;

    chatBox.innerHTML = '';

    // Fetch all messages for the selected contact
    axios.get(`/messages/${contactId}`)
        .then(response => {
            console.log("Fetched messages:", response.data); // Log the API response

            const messages = response.data;

            // Display all the messages
            messages.forEach(msg => {
                appendMessage(msg, msg.from === emp_id);
            });

            // Update the last message time
            if (messages.length > 0) {
                lastMessageTime = messages[messages.length - 1].timestamp;
            }
        })
        .catch(error => console.error("Error fetching messages for this contact", error));
}


let timeoutId = null;


messageForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const message = messageInput.value.trim();
    const documentInput = document.getElementById('document');
    const documentFile = documentInput.files[0]; // Get the selected file (if any)

    const formData = new FormData();
    formData.append('from', emp_id);
    formData.append('to', currentContact);

    
    if (message) {
        formData.append('message', message);
    }

    
    if (documentFile) {
        formData.append('document', documentFile);
    }

    if (message || documentFile) {
        const sendButton = messageForm.querySelector('button[type="submit"]');
        sendButton.disabled = true;

        // Send the data to the server
        axios.post('/send-message', formData)
            .then(response => {
                const responseData = response.data;

                
                appendMessage(responseData, true);
                lastMessageTime = responseData.timestamp;

                messageInput.value = '';
                documentInput.value = '';
                document.getElementById('file-name').textContent = "No file chosen";

                moveContactToTop(currentContact);

                if (timeoutId) {
                    clearTimeout(timeoutId);
                }

                timeoutId = setTimeout(() => {
                    deactivateChat(responseData.message_id);
                }, 5 * 60 * 1000);
            })
            .catch(error => console.error("Error sending the message", error))
            .finally(() => {
                sendButton.disabled = false;
            });
    } else {
        alert('Please enter a message or select a file to send.');
    }
});


function deactivateChat(messageId) {
    axios.post('/deactivate-chat', {
        message_id: messageId,
    })
    .then(response => {
        console.log('Chat deactivated:', response.data);
    })
    .catch(error => {
        console.error('Error deactivating chat:', error);
    });
}

setInterval(() => {
    if (currentContact) {
        // Fetch new messages
        axios.get(`/messages/${currentContact}`)
            .then(response => {
                const messages = response.data;

                
                if (messages.length > 0) {
                    const newMessages = messages.filter(msg => msg.timestamp > lastMessageTime && !sentMessageIds.has(msg.id));

                    newMessages.forEach(msg => {
                        appendMessage(msg, msg.from === emp_id);
                    });

                    const latestMessage = messages[messages.length - 1];
                    lastMessageTime = latestMessage.timestamp;

                    
                    messages.forEach(msg => {
                        const messageTimestamp = new Date(msg.timestamp);
                        const currentTime = new Date();

                        if (msg.active_chat && (currentTime - messageTimestamp >= 2 * 60 * 1000)) {
                            axios.post('/deactivate-chat', { message_id: msg.id })
                                .then(response => {
                                    console.log('Chat deactivated:', response.data);
                                })
                                .catch(error => {
                                    console.error('Error deactivating chat:', error);
                                });
                        }
                    });
                }
            })
            .catch(error => console.error("Error fetching new messages", error));
    }
}, 4000);



function fetchUnreadMessages() {
    axios.get('/unread-messages')
        .then(response => {
            const unreadMessages = response.data;
            // console.log("Unread messages response:", unreadMessages); // Debug the server response

            // Iterate through each contact and update the unread count in the UI
            for (let phoneNumber in unreadMessages) {
                const unreadCount = unreadMessages[phoneNumber];

                if (!unreadCount && unreadCount !== 0) continue;

                const contactElement = document.querySelector(`[data-phone="${phoneNumber}"]`);
                
                if (!contactElement) {
                    console.error(`Contact element for ${phoneNumber} not found`);
                    continue;
                }

                const unreadBadge = contactElement.querySelector('.unread-count');
                
                if (unreadCount > 0) {
                    unreadBadge.textContent = unreadCount;
                    unreadBadge.style.display = 'inline-block';
                } else {
                    unreadBadge.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Error fetching unread messages', error));
}

// Open chat for selected phone number
function openChats(phoneNumber) {
    axios.get(`/messages/${phoneNumber}`)
        .then(response => {
            if (!response.data || response.data.length === 0) {
                // console.log("No messages found.");
                return;
            }

            response.data.forEach(message => {
                // appendMessage(message, message.from === phoneNumber);
            });

            return axios.post('/mark-messages-read', { phoneNumber });
        })
        .then(response => {
            if (response && response.data.success) {
                console.log(`Marked ${response.data.updatedCount} messages as read.`);
                fetchUnreadMessages(); // Refresh unread count
            } else {
                // console.error("Failed to mark messages as read:", response?.data?.error);
            }
        })
        .catch(error => console.error("Error loading messages!", error));
}

setInterval(fetchUnreadMessages, 2000);

fetchUnreadMessages();

});

    document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const chatBox = document.getElementById('chat-box');
    const contactsList = document.getElementById('contacts');

    const searchMessages = (query) => {
        const messages = chatBox.querySelectorAll('.message');
        messages.forEach((message) => {
            if (message.textContent.toLowerCase().includes(query.toLowerCase())) {
                message.style.display = 'block';
            } else {
                message.style.display = 'none';
            }
        });
    };

    const searchContacts = (query) => {
        const contacts = contactsList.querySelectorAll('.contact-item');
        contacts.forEach((contact) => {
            if (contact.textContent.toLowerCase().includes(query.toLowerCase())) {
                contact.style.display = 'flex';
            } else {
                contact.style.display = 'none';
            }
        });
    };
    
    searchInput.addEventListener('input', (event) => {
        const query = event.target.value.trim();
        if (query) {
            searchMessages(query); 
            searchContacts(query); 
        } else {
            chatBox.querySelectorAll('.message').forEach((message) => (message.style.display = 'block'));
            contactsList.querySelectorAll('.contact-item').forEach((contact) => (contact.style.display = 'flex'));
        }
    });
});



</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function refreshContacts() {
        $.ajax({
            url: "{{ route('get.latest.contacts') }}",
            type: "GET",
            success: function (response) {
                if (response.contacts.length > 0) {
                    let contactListHtml = "";
                    response.contacts.forEach(contact => {
                        contactListHtml += `
                            <li class="contact-item" data-phone="${contact.phone_number}">
                                <img src="{{ asset('assets/human_icon1.jpeg') }}" alt="">
                                <span>${contact.phone_number}</span>
                                <span class="unread-count" style="display: ${contact.unread_count > 0 ? 'inline-block' : 'none'};">
                                    ${contact.unread_count}
                                </span>
                            </li>`;
                    });

                    $("#contacts").html(contactListHtml);
                }
            },
            error: function (xhr) {
                console.error("Error fetching contacts:", xhr.responseText);
            }
        });
    }
    setInterval(refreshContacts, 5000);


    
</script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<script>
let pingUrl = '/agent-ping';

// Get CSRF token from meta tag
let csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : null;

if (!csrfToken) {
    console.error("CSRF token not found!");
}


// Periodically send a ping request to keep connection alive
function startPing() {
    setInterval(async () => {
        try {
            const response = await fetch(pingUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,  // Attach CSRF token here
                },
            });
            if (response.ok) {
                // console.log("Agent is online");
            }
        } catch (error) {
            console.log("Connection lost, setting agent offline...");
            navigator.sendBeacon("/logout");
        }
    }, 5000);
}
document.addEventListener("DOMContentLoaded", startPing);


window.addEventListener("beforeunload", function () {
        let empId = "{{ Auth::user()->emp_id ?? '' }}"; 
        if (empId) {
            axios.post('/logout-agent', { emp_id: empId })
                .then(response => console.log(response.data))
                .catch(error => console.error("Logout error:", error));
        }
    });
</script>


</body>
</html>
