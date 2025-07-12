const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let response = xhr.responseText;
              if(response === "success"){
                  inputField.value = "";
                  scrollToBottom();
              }else if(response === "blocked"){
                  alert("Cette conversation a été bloquée. Vous ne pouvez plus envoyer de messages.");
                  inputField.value = "";
              }else{
                  console.log("Erreur lors de l'envoi:", response);
              }
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

// Fonction pour répondre aux invitations
function respondToInvitation(msgId, response) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/respond-invitation.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                if(xhr.responseText === "success"){
                    // Masquer les boutons d'invitation
                    const invitationButtons = document.querySelector(`[onclick*="${msgId}"]`).parentElement;
                    invitationButtons.style.display = 'none';
                    
                    // Afficher un message de confirmation
                    const messageElement = invitationButtons.parentElement.querySelector('p');
                    if(response === 'accepted'){
                        messageElement.innerHTML += ' <span class="invitation-status accepted">✓ Invitation acceptée</span>';
                    }else{
                        messageElement.innerHTML += ' <span class="invitation-status declined">✗ Invitation déclinée</span>';
                        // Désactiver le formulaire d'envoi
                        inputField.disabled = true;
                        sendBtn.disabled = true;
                        inputField.placeholder = "Conversation bloquée";
                    }
                }
            }
        }
    }
    let formData = new FormData();
    formData.append('msg_id', msgId);
    formData.append('response', response);
    xhr.send(formData);
}

chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id);
}, 500);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  