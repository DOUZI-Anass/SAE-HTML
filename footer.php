<!-- FOOTER -->
<footer>
    <div class="container py-5">
        <div class="row gy-4 text-center text-md-start">
            <div class="col-md-3"><img src="assets/image/LogoFageBlanc.png" class="footer-logo mb-3" alt="Logo"></div>
            <div class="col-md-3"><h5>LA FAGE</h5><ul class="list-unstyled"><li>Qui sommes-nous ?</li><li>Nos idées</li><li>Innovation sociale</li><li>Service</li></ul></div>
<div class="col-md-3">
  <h5>Suivez-nous</h5>
  <div class="d-flex gap-3 fs-4 justify-content-center justify-content-md-start">
    <a href="https://www.facebook.com/fage.fr" target="_blank" aria-label="Facebook" style="color: inherit; text-decoration: none;">
      <i class="bi bi-facebook"></i>
    </a>
    <a href="https://x.com/La_FAGE" target="_blank" aria-label="X (Twitter)" style="color: inherit; text-decoration: none;">
      <i class="bi bi-twitter-x"></i>
    </a>
    <a href="https://www.linkedin.com/company/la-fage/" target="_blank" aria-label="LinkedIn" style="color: inherit; text-decoration: none;">
      <i class="bi bi-linkedin"></i>
    </a>
    <a href="https://www.instagram.com/la_fage/" target="_blank" aria-label="Instagram" style="color: inherit; text-decoration: none;">
      <i class="bi bi-instagram"></i>
    </a>
  </div>
</div>
            <div class="col-md-3"><h5>Contact</h5><p>79 rue Périer, 92120 Montrouge</p><p>Tél : 01 40 33 70 70</p></div>
        </div>
        <hr class="my-4">
        <div class="text-center small">© 2025 FAGE — Tous droits réservés</div>
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

</body>
</html>

