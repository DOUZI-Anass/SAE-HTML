<div id="chatbot-btn" onclick="toggleChat()">
    <i class="fa-solid fa-robot"></i> Besoin d'aide ?
</div>

<div id="chat-window">
    <div class="chat-header">
        <span>🤖 Assistant FAGE</span>
        <span class="close-chat" onclick="toggleChat()">×</span>
    </div>
    <div class="chat-body" id="chat-body">
        <div class="message bot">
            Bonjour ! Je suis l'assistant virtuel de la FAGE. Comment puis-je vous aider ?
        </div>
    </div>
    <div class="chat-footer">
        <input type="text" id="chat-input" placeholder="Posez votre question..." onkeypress="handleKeyPress(event)">
        <button onclick="sendMessage()"><i class="fa-solid fa-paper-plane"></i></button>
    </div>
</div>

<style>
    /* Bouton flottant en bas à droite */
    #chatbot-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: var(--fage-blue, #0099cc); /* Bleu par défaut si la variable manque */
        color: #ffffff !important;
        padding: 15px 25px;
        border-radius: 30px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        z-index: 9999;
        font-weight: bold;
        transition: transform 0.3s;
        font-family: sans-serif;
    }
    #chatbot-btn:hover { transform: scale(1.05); }

    /* Fenêtre de chat (cachée par défaut) */
    #chat-window {
        display: none;
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 350px;
        height: 450px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.2);
        z-index: 9999;
        flex-direction: column;
        overflow: hidden;
        font-family: 'Helvetica', sans-serif;
    }

    .chat-header {
        background-color: var(--fage-blue, #0099cc);
        color: white !important;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
    }
    .close-chat { cursor: pointer; font-size: 1.5rem; }

    .chat-body {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background-color: #f9f9f9;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* Styles des messages */
    .message {
        padding: 10px 15px;
        border-radius: 15px;
        max-width: 80%;
        font-size: 0.9rem;
        line-height: 1.4;
        color: #333 !important; /* Force le texte en noir */
    }
    .message.bot {
        background-color: #0081ff;
        align-self: flex-start;
        border-bottom-left-radius: 2px;
    }
    .message.user {
        background-color: var(--fage-blue, #0099cc);
        color: white !important;
        align-self: flex-end;
        border-bottom-right-radius: 2px;
    }

    /* Liens dans le chat */
    .message a {
        color: inherit;
        text-decoration: underline;
        font-weight: bold;
    }

    .chat-footer {
        padding: 10px;
        border-top: 1px solid #eee;
        display: flex;
        gap: 10px;
        background: white;
    }
    #chat-input {
        flex: 1;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 8px 15px;
        outline: none;
        color: #333 !important; /* Texte noir */
    }
    .chat-footer button {
        background: var(--fage-blue, #0099cc);
        color: white;
        border: none;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        cursor: pointer;
    }
    /* Force les liens du robot à être bleus et visibles */
    .message.bot a {
        color: #0099cc !important; /* Bleu FAGE */
        font-weight: bold;
        text-decoration: underline;
    }

    /* Optionnel : Change la couleur au survol de la souris */
    .message.bot a:hover {
        color: #0056b3 !important; /* Bleu plus foncé */
    }
</style>

<script>
    // 1. Ouvrir/Fermer
    function toggleChat() {
        const chatWindow = document.getElementById('chat-window');
        if (chatWindow.style.display === 'flex') {
            chatWindow.style.display = 'none';
        } else {
            chatWindow.style.display = 'flex';
            document.getElementById('chat-input').focus();
        }
    }

    // 2. Touche Entrée
    function handleKeyPress(e) {
        if (e.key === 'Enter') sendMessage();
    }

    // 3. Envoyer
    function sendMessage() {
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        if (message === "") return;

        addMessage(message, 'user');
        input.value = "";

        setTimeout(() => {
            const botResponse = getBotResponse(message);
            addMessage(botResponse, 'bot');
        }, 600);
    }

    // 4. Ajouter message
    function addMessage(text, sender) {
        const chatBody = document.getElementById('chat-body');
        const div = document.createElement('div');
        div.classList.add('message', sender);
        div.innerHTML = text;
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // ============================================================
    // 🧠 CERVEAU DU ROBOT (Partie Intelligente)
    // ============================================================
    function getBotResponse(input) {
        // 1. Nettoyage du texte pour éviter les erreurs (minuscules + sans accents)
        input = input.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        // --- 2. POLITESSE (Doit être en premier) ---
        if (input.includes("bonjour") || input.includes("salut") || input.includes("coucou") || input.includes("hello")) {
            return "Bonjour ! 👋 Je suis l'assistant FAGE. Je peux vous guider vers nos événements, nos formations ou nos actualités.";
        }
        else if (input.includes("merci")) {
            return "Avec plaisir ! N'hésitez pas si vous avez d'autres questions. 😊";
        }
        else if (input.includes("revoir") || input.includes("bye")) {
            return "Au revoir et à bientôt ! 👋";
        }
        else if (input.includes("ca va")) {
            return "Je suis un robot, donc toujours en forme ! Et vous ? 🦾";
        }

        // --- 3. LE GPS / PLAN (Votre ajout) ---
        else if (input.includes("gps") || input.includes("plan") || input.includes("carte") || input.includes("map")) {
            return "Si votre GPS ne fonctionne plus, voici le lien direct vers Google Maps : <br>📍 <a href='https://www.google.com/maps/search/?api=1&query=79+Rue+Périer+92120+Montrouge' target='_blank'><b>Ouvrir le plan d'accès</b></a>.";
        }

        // --- 4. ÉVÉNEMENTS ---
        else if (input.includes("inscription") || input.includes("inscrire") || input.includes("participer")) {
            return "Pour vous inscrire, rendez-vous sur la page <a href='evenements.php'><b>Événements</b></a>.";
        }
        else if (input.includes("evenement") || input.includes("agenda")) {
            return "Consultez notre <a href='agenda.php'><b>Agenda complet</b></a> pour les dates clés.";
        }

        // --- 5. INFOS & CONTACT ---
        else if (input.includes("qui") || input.includes("sommes")) {
            return "La FAGE est la première organisation étudiante représentative. <a href='quiSommeNous.php'><b>En savoir plus</b></a>.";
        }
        else if (input.includes("contact") || input.includes("tel") || input.includes("mail") || input.includes("adresse")) {
            return "📍 79 Rue Périer, 92120 Montrouge<br>📞 01 40 33 70 70<br>📧 contact@fage.org";
        }

        // --- 6. SANTÉ ---
        else if (input.includes("sante") || input.includes("psy")) {
            return "La santé étudiante est notre priorité ! Découvrez nos actions : <a href='vivreEnBonneSante.php'><b>Santé</b></a>.";
        }

        // --- 7. BÉNÉVOLES ---
        else if (input.includes("benevole") || input.includes("formation")) {
            return "Rejoignez-nous ! Infos sur la formation ici : <a href='benevole.php'><b>Formation des Bénévoles</b></a>.";
        }

        // --- 8. COMPTE ---
        else if (input.includes("connect") || input.includes("compte") || input.includes("login") || input.includes("passe")) {
            return "Connectez-vous ou réinitialisez votre mot de passe ici : <a href='connexion.php'><b>Connexion</b></a>.";
        }

        // --- 9. DÉFAUT (Si rien ne correspond) ---
        else {
            return "Je ne suis pas sûr de comprendre. Essayez des mots clés comme 'inscription', 'GPS', 'contact' ou 'santé'.";
        }
    }
    </script>