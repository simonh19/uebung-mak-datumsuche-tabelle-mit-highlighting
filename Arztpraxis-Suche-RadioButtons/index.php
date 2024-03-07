<?php
if (session_id() == '') {
    session_start();
}
include 'helper/suche.php';
include 'helper/form_functions.php';
include 'helper/database_functions.php';

$anzahl = 0;
$hasValidationError = false;
$gefundenePatienten = null;
$svnVorhanden = isset($_GET['date-start']) && !empty($_GET['date-start']);
$dateEndVorhanden = isset($_GET['date-end']) && !empty($_GET['date-end']);

if ($svnVorhanden || $dateEndVorhanden) {
    $gefundenePatienten = processForm($_GET);
    $anzahl = $gefundenePatienten -> rowCount();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">BS Linz 2</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="index.php">⦁	Startseite</a>
        </div>
    </div>
</nav>
<div class="card border-0 shadow p-4 container d-flex align-items-center flex-column mt-4 gap-4">
    <h2>Willkommen in der Bücherei.</h2>
    
    <form action="index.php" method="get">
        <h3 class="mt-3">Verliehene Bücher in einem gewissen Zeitraum anzeigen:</h3>
        <div class="mt-3">
        <div class="row">
            <label required class="col-md-3" for="suchbegriff">von Datum</label>
            <input type="date" class="col-md-9 p-1 rounded" id="date-start" name="date-start">
        </div>
        <div class="row mt-3">
            <label required class="col-md-3" for="suchbegriff">bis Datum</label>
            <input type="date" class="col-md-9 p-1 rounded" id="date-end" name="date-end">
        </div>
        
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Suche starten</button>
        </div>
        </div>
    </form>
    
    <div>
        <?php if ($gefundenePatienten!=null && $anzahl > 0): ?>
        <?php
                             
            echo generateTableFromQuery($gefundenePatienten);?>
        <?php elseif ($gefundenePatienten!=null): {
           $warningText="Keine Ergebnisse für ". $_GET['date-start'] ." gefunden.";
           showAlertWarning($warningText);
        }
        ?>
                 
        <?php endif; ?>
    </div>
    </div>
</body>
</html>