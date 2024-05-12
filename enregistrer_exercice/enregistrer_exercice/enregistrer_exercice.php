<?php
var_dump($_POST);


require_once('connexion_db.php');

// Vérifie si la requête est une requête AJAX
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Vérifie si les données POST existent
    if (isset($_POST['exercise-name'], $_POST['exercise-subject'], $_POST['exercise-level'], $_POST['exercise-type'], $_POST['exercise-difficulty'], $_POST['exercise-duration'], $_POST['origines'], $_POST['source-site'])) {
        // Récupère les données du formulaire
        $exerciseName = $_POST['exercise-name'];
        $exerciseSubject = $_POST['exercise-subject'];
        $exerciseLevel = $_POST['exercise-level'];
        $exerciseType = $_POST['exercise-type'];
        $exerciseDifficulty = $_POST['exercise-difficulty'];
        $exerciseDuration = $_POST['exercise-duration'];
        $origines = $_POST['origines'];
        $sourceSite = $_POST['source-site'];

        // Insérez les données dans la base de données
        $stmt = $pdo->prepare("INSERT INTO math_index (exercise_name, exercise_subject, exercise_level, exercise_type, exercise_difficulty, exercise_duration, origines, source_site) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$exerciseName, $exerciseSubject, $exerciseLevel, $exerciseType, $exerciseDifficulty, $exerciseDuration, $origines, $sourceSite]);

        // Renvoie une réponse JSON indiquant le succès de l'opération
        echo json_encode(['success' => true]);
        exit;
    } else {
        // Si les données POST sont manquantes, renvoie une réponse d'erreur
        echo json_encode(['success' => false, 'message' => 'Des données sont manquantes']);
        exit;
    }
} else {
    // Si ce n'est pas une requête AJAX, renvoie une réponse d'erreur
    echo json_encode(['success' => false, 'message' => 'Requête non autorisée']);
    exit;
}
?>
