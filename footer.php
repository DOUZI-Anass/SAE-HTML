<!-- FOOTER -->
<footer class="footer">
  <div class="footer-container">

    <!-- 🔹 LOGO -->
    <div class="footer-logo">
        <link rel="stylesheet" href="assets/style.css">
      <img src="assets/image/logo-fage.png" alt="Logo FAGE">
      <p>Fédération des Associations Générales Étudiantes</p>
      <p>79 rue Périer, 92120 Montrouge</p>
      <p>Tél : <a href="tel:+33140337070">01 40 33 70 70</a></p>
    </div>

    <!-- 🔹 RUBRIQUE : LA FAGE -->
    <div class="footer-col">
      <h4>LA FAGE</h4>
      <ul>
        <li><a href="quiSommeNous.php">Qui sommes-nous ?</a></li>
        <li><a href="#">Nos actions</a></li>
        <li><a href="#">Nos valeurs</a></li>
        <li><a href="#">Notre mission</a></li>
          <?php if (!empty($_SESSION['benevole']) && (($_SESSION['benevole']['role'] ?? '') === 'administrateur')): ?>
              <li><a href="admin.php">Admin</a></li>
          <?php endif; ?>

      </ul>
    </div>

    <!-- 🔹 RUBRIQUE : NOS IDÉES -->
    <div class="footer-col">
      <h4>NOS IDÉES</h4>
      <ul>
        <li><a href="#">Représentation étudiante</a></li>
        <li><a href="#">Égalité des chances</a></li>
        <li><a href="#">Santé et bien-être</a></li>
        <li><a href="#">Logement et vie étudiante</a></li>
      </ul>
    </div>

    <!-- 🔹 RUBRIQUE : INNOVATION SOCIALE -->
    <div class="footer-col">
      <h4>INNOVATION SOCIALE</h4>
      <ul>
        <li><a href="#">Entrepreneuriat étudiant</a></li>
        <li><a href="#">Projets solidaires</a></li>
        <li><a href="#">Développement durable</a></li>
      </ul>
    </div>

    <!-- 🔹 RUBRIQUE : SERVICES -->
    <div class="footer-col">
      <h4>SERVICES</h4>
      <ul>
        <li><a href="Formation_benevole.php">Formation des bénévoles</a></li>
        <li><a href="#">Financer ses projets</a></li>
        <li><a href="#">Catalogue de formations</a></li>
      </ul>
    </div>
  </div>

  <!-- 🔹 BAS DE PAGE -->
  <div class="footer-bottom">
    <div class="social-icons">
      <a href="https://www.facebook.com/fage.officiel" target="_blank"><i class="bi bi-facebook"></i></a>
      <a href="https://x.com/FAGEOfficiel" target="_blank"><i class="bi bi-twitter-x"></i></a>
      <a href="https://www.linkedin.com/company/fage" target="_blank"><i class="bi bi-linkedin"></i></a>
    </div>
    <p>
      <a href="#">Plan du site</a> |
      <a href="#">Mentions légales</a> |
      <a href="#">Politique de confidentialité</a>
    </p>
    <p>© 2025 FAGE — Tous droits réservés</p>
  </div>
</footer>


<script>
    const navbar = document.getElementById('navbar');
    const searchBtn = document.getElementById('searchBtn');
    const searchInput = document.getElementById('searchInput');

    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 200);
    });

    searchBtn.addEventListener('click', () => searchInput.classList.toggle('show'));
</script>


