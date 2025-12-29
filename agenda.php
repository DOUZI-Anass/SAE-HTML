<?php
require 'header.php';
?>
<div class="container" style="margin-top:120px;">
    <h1 class="mb-4">Calendrier des événements</h1>
    <div id="calendar"></div>
</div>

<!-- FullCalendar (CDN) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(el, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            height: 'auto',
            firstDay: 1,
            events: 'event.php',

            eventClick: function(info) {
                const e = info.event;

                let html = `
                <h5>${e.title}</h5>
                <p><strong>Lieu :</strong> ${e.extendedProps.lieu ?? '-'}</p>
                <p><strong>Budget :</strong> ${e.extendedProps.budget ?? '-'} €</p>
                <p>${e.extendedProps.description ?? ''}</p>
            `;

                <?php if (isset($_SESSION['benevole'])): ?>
                html += `
                <button class="btn btn-primary mt-2" onclick="inscrire(${e.id})">
                    S’inscrire à l’événement
                </button>
            `;
                <?php else: ?>
                html += `
                <p class="text-danger mt-2">
                    Connectez-vous pour vous inscrire.
                </p>
            `;
                <?php endif; ?>

                const wrapper = document.createElement('div');
                wrapper.innerHTML = `
                <div class="modal fade show" style="display:block; background:rgba(0,0,0,.5)">
                    <div class="modal-dialog">
                        <div class="modal-content p-3">
                            ${html}
                            <button class="btn btn-secondary mt-3" onclick="this.closest('.modal').remove()">Fermer</button>
                        </div>
                    </div>
                </div>
            `;
                document.body.appendChild(wrapper);
            }
        });

        calendar.render();
    });

    // fonction globale appelée par le bouton.
    function inscrire(idEvenement) {
        fetch('inscription_evenement.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id_evenement=' + encodeURIComponent(idEvenement)
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Inscription réussie 🎉');
                } else {
                    alert(data.error ?? 'Erreur');
                }
            })
            .catch(() => alert('Erreur réseau'));
    }
</script>

<?php require 'footer.php'; ?>
