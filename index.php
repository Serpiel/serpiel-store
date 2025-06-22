
<?php include 'bdd.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Welcome</title>
    <link rel="icon" type="image/x-icon" href="">
    <link rel="stylesheet" href="style/content.css">
</head>
<script src="Interactions/video.js"></script>
<body>
    <?php include 'navbar.php'; ?>
    <!-- Vidéo desktop -->
    <video autoplay muted playsinline id="video-desktop">
        <source src="Assets/serpiel_logo.mp4" type="video/mp4">
    </video>

    <!-- Vidéo mobile -->
    <video autoplay muted playsinline id="video-mobile">
        <source src="Assets/serpiel_logo_mobile.mp4" type="video/mp4">
    </video>
    <?php include 'footer.php'; ?>
</body>
</html>