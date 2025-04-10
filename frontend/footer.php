<footer style="
    background: rgba(30, 20, 18, 0.95);
    border-top: 1px solid var(--rich-amber);
    padding: 2rem 0;
    margin-top: 3rem;
    text-align: center;
    font-family: 'Cormorant Garamond', serif;
">
    <div style="
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        text-align: left;
    ">
        <div>
            <h3 style="
                color: var(--rich-amber);
                font-size: 1.5rem;
                margin-bottom: 1rem;
                border-bottom: 1px solid var(--rich-amber);
                padding-bottom: 0.5rem;
            ">
                Tè e Tabacchi
            </h3>
            <p style="line-height: 1.6;">
                Questo diario è stato creato come esercizio di stile ma se lo trovi utile mi fa piacere.
        </div>
        <div style="margin-top: 1rem;">
    <?php if(isset($_SESSION['logged_in'])): ?>
        <span style="color: var(--tea-green);">Benvenuto, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" style="color: var(--tea-green); margin-left: 1rem;">Logout</a>
    <?php else: ?>
        <a href="C:\xampp\htdocs\mydashboard\CyteaPipe\login.php" style="color: var(--tea-green);">Login</a>
        <a href="C:\xampp\htdocs\mydashboard\CyteaPipe\register.php" style="color: var(--tea-green); margin-left: 1rem;">Registrati</a>
    <?php endif; ?>
</div>
        <div>
            <h3 style="
                color: var(--rich-amber);
                font-size: 1.5rem;
                margin-bottom: 1rem;
                border-bottom: 1px solid var(--rich-amber);
                padding-bottom: 0.5rem;
            ">
                Collegamenti
            </h3>
            <ul style="list-style: none; padding: 0; line-height: 2;">
                                <li><a href="products.php" style="color: var(--warm-parchment); text-decoration: none;">📜 Prodotti</a></li>
                                <li><a href="register.php" style="color: var(--warm-parchment); text-decoration: none;">👤 Registrati</a></li>
            </ul>
        </div>
        
        <div>
            <h3 style="
                color: var(--rich-amber);
                font-size: 1.5rem;
                margin-bottom: 1rem;
                border-bottom: 1px solid var(--rich-amber);
                padding-bottom: 0.5rem;
            ">
                Contatti
            </h3>
            <ul style="list-style: none; padding: 0; line-height: 2;">
                <li><i class="fas fa-map-marker-alt" style="color: var(--rich-amber); width: 20px;"></i>Full stack Dev. Valerio Pasqua</li>
                <li><i class="fas fa-phone" style="color: var(--rich-amber); width: 20px;"></i> +393519100879</li>
                <li><i class="fas fa-envelope" style="color: var(--rich-amber); width: 20px;"></i> valeriopasquapro@gmail.com</li>
            </ul>
        </div>
    </div>
    
    <div style="
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(214, 167, 92, 0.3);
        text-align: center;
        font-size: 0.9rem;
        color: var(--tea-green);
    ">
        <p>
            &copy; <?= date('Y') ?> Tabacco & Tè. Tutti i diritti riservati.
        </p>
        <p style="margin-top: 0.5rem; font-size: 0.8rem;">
          <a href="#" style="color: var(--tea-green);">Privacy Policy</a> | <a href="#" style="color: var(--tea-green);">Termini e Condizioni</a>
        </p>
    </div>
</footer>