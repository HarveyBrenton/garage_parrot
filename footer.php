<footer>
<div class="footer-links">
    <ul>
      <li><a href="#">Accueil</a></li>
      <li><a href="#">Services</a></li>
      <li><a href="#">Véhicules d'occasion</a></li>
      <li><a href="#">Avis clients</a></li>
    </ul>
  </div>

  
  <div class="footer-contact">
    <a href="contact.php">Contact</a>
  </div>


  <?php
// Inclure le fichier de configuration de la base de données
include 'dns.php';

// Récupérer les horaires depuis la base de données
$stmt = $conn->query("SELECT * FROM opening_hours LIMIT 1");
$openingHours = $stmt->fetch(PDO::FETCH_ASSOC);

// Définir les variables des horaires
$monHours = $openingHours['mon_hours'];
$tueHours = $openingHours['tue_hours'];
$wedHours = $openingHours['wed_hours'];
$thuHours = $openingHours['thu_hours'];
$friHours = $openingHours['fri_hours'];
$satHours = $openingHours['sat_hours'];
$sunHours = $openingHours['sun_hours'];
?>

<div class="footer-hours">
    <h3>Horaires d'ouverture</h3>
    <label>Lun. :</label>
    <span><?php echo $monHours; ?></span><br>

    <label>Mar. :</label>
    <span><?php echo $tueHours; ?></span><br>

    <label>Mer. :</label>
    <span><?php echo $wedHours; ?></span><br>

    <label>Jeu. :</label>
    <span><?php echo $thuHours; ?></span><br>

    <label>Ven. :</label>
    <span><?php echo $friHours; ?></span><br>

    <label>Sam. :</label>
    <span><?php echo $satHours; ?></span><br>

    <label>Dim. :</label>
    <span><?php echo $sunHours; ?></span><br>
</div>


</footer>

<script src="/assets/script.js"></script>
<script src="/assets/jquery-3.7.0.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</body>
</html>
