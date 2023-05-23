<?php include 'cookies.php'; ?>
<?php include 'header.php'; ?>


<h2>Formulaire de contact</h2>
<form action="submit_contact.php" method="POST">
        <input type="hidden" name="car_id" value="<?php echo $carId; ?>">
        
        <div class="form-group">
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="email">Adresse e-mail :</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="phone">Numéro de téléphone :</label>
            <input type="tel" name="phone" id="phone" required>
        </div>

        <div class="form-group">
        <label for="message">Message :</label>
        <textarea name="message" required></textarea>
        </div>

        <button type="submit">Envoyer</button>
    </form>


    <?php include 'footer.php'; ?>