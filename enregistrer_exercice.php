<?php
$formatedData = json_decode(file_get_contents('php://input'), true);
$id = $_COOKIE[$id];
if ($formatedData !== null) {
    $_POST = $formatedData;
}
require_once('connexion_db.php');

// Vérifie si la requête est une requête AJAX
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Vérifie si les données POST existent
    if (isset($_POST['generalInfo']['exerciseName'], $_POST['generalInfo']['exerciseSubject'], $_POST['generalInfo']['exerciseLevel'], $_POST['generalInfo']['exerciseChapitre'],$_POST['generalInfo']['keyword'],$_POST['generalInfo']['exerciseLevel'], $_POST['generalInfo']['exerciseDifficulty'], $_POST['generalInfo']['exerciseDuration'], $_POST['sources']['origine'], $_POST['sources']['sourceSite'])) {
        // Récupère les données du formulaire
        $exerciseName = $_POST['generalInfo']['exerciseName'];
        $exerciseSubject = $_POST['generalInfo']['exerciseSubject'];
        $exerciseLevel = $_POST['generalInfo']['exerciseLevel'];
        $exerciseType = $_POST['generalInfo']['exerciseType'];
        $exerciseChapitre = $_POST['generalInfo']['exerciseChapitre'];
        $keyword = $_POST['generalInfo']['keyword'];
        $exerciseDifficulty = $_POST['generalInfo']['exerciseDifficulty'];
        $exerciseDuration = $_POST['generalInfo']['exerciseDuration'];
        $origine = $_POST['sources']['origine'];
        $sourceSite = $_POST['sources']['sourceSite'];


        

        try {
            // Insérer les données dans la table thematic
            $pdo = connectToDatabase();

            $stmt = $pdo->prepare("INSERT INTO classroom (name) VALUES (?)");
            $stmt->execute([$exerciseLevel]);
            $classroomId = $pdo->lastInsertId();

            $stmt = $pdo->prepare("INSERT INTO thematic (name, subject) VALUES (?, ?)");
            $stmt->execute([$exerciseType,  $exerciseSubject]); 
            $thematicId = $pdo->lastInsertId();

            $stmt = $pdo->prepare("INSERT INTO exercise (name,classroom_id,thematic_id, chapter,keywords, difficulty, duration, origin_id,exercise_file_id,correction_file_id,created_by_id) VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?,?)");
            $stmt->execute([$exerciseName, $classroomId, $thematicId, $exerciseChapitre, $keyword, $exerciseDifficulty, $exerciseDuration, $origine, null, null, $id]);

            echo json_encode(['success' => true]);
            exit;
        } catch (PDOException $e) {
            // Si une erreur SQL se produit, renvoie une réponse d'erreur avec le message d'erreur
            echo json_encode(['success' => false, 'message' => 'Erreur SQL : ' . $e->getMessage()]);
            exit;
        }
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
