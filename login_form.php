<?php
include 'header.php';
?>



<h1>Page de connexion</h1>


<!--FORMULAIRE DE CONNEXION-->
<section class="section_conn_form">
    <div class="conn_form">
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">Adresse e-mail :</label>
            <input type="email" name="email" id="email" placeholder="Adresse e-mail" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" placeholder="Mot de passe" required>
        </div>

        <button type="submit">Se connecter</button>
    </form>
    </div>
</section>


<?php
include 'footer.php';
?>
