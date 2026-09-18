<form action="/admin/login" method="POST" class="auth-form">
    <?= $csrfField ?>

    <div class="form-group">
        <label for="email">Adresse Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="admin@espoir-avenir.ong" required autofocus>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
    </div>

    <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top: 20px;">
        Se connecter au CRM
    </button>
</form>

<div class="demo-credentials-box">
    <p><strong>Compte Démo :</strong></p>
    <p>Email : <code>admin@espoir-avenir.ong</code></p>
    <p>Mot de passe : <code>admin123</code></p>
</div>
