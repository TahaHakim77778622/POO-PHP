<?php
class Note {
    private $student;
    private $subject;
    private $grade;

    public function __construct($student, $subject, $grade) {
        $this->student = $student;
        $this->subject = $subject;
        $this->grade = $grade;
    }

    public function getStudent() {
        return $this->student;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getGrade() {
        return $this->grade;
    }

    public function display() {
        echo '
        <div class="box">
            <h3>' . $this->getStudent() . '</h3>
            <p>Matière: ' . $this->getSubject() . '</p>
            <p>Note: ' . $this->getGrade() . '</p>
            <a href="#"><button class="button">Modifier</button></a>
        </div>';
    }
}

class EmploiDuTemps {
    private $group;
    private $schedule;

    public function __construct($group, $schedule) {
        $this->group = $group;
        $this->schedule = $schedule;
    }

    public function getGroup() {
        return $this->group;
    }

    public function getSchedule() {
        return $this->schedule;
    }

    public function display() {
        echo '
        <div class="box">
            <h3>' . $this->getGroup() . '</h3>
            <p>Emploi: ' . $this->getSchedule() . '</p>
            <a href="#"><button class="button">Voir détails</button></a>
        </div>';
    }
}

class Professeur {
    private $notes = [];
    private $emploisDuTemps = [];

    public function addNote(Note $note) {
        $this->notes[] = $note;
    }

    public function addEmploiDuTemps(EmploiDuTemps $emploi) {
        $this->emploisDuTemps[] = $emploi;
    }

    public function displayNotes() {
        foreach ($this->notes as $note) {
            $note->display();
        }
    }

    public function displayEmploisDuTemps() {
        foreach ($this->emploisDuTemps as $emploi) {
            $emploi->display();
        }
    }
}

// Inclure les classes
include 'Note.php';
include 'EmploiDuTemps.php';
include 'Professeur.php';

// Créer des instances de notes et d'emplois du temps
$professeur = new Professeur();

$note1 = new Note('John Doe', 'Mathématiques', 15);
$note2 = new Note('Jane Smith', 'Physique', 18);
$note3 = new Note('Alex Johnson', 'Chimie', 13);

$professeur->addNote($note1);
$professeur->addNote($note2);
$professeur->addNote($note3);

$emploi1 = new EmploiDuTemps('Groupe A', 'Lundi: 8h - 12h, Mercredi: 14h - 18h');
$emploi2 = new EmploiDuTemps('Groupe B', 'Mardi: 9h - 13h, Jeudi: 15h - 19h');
$emploi3 = new EmploiDuTemps('Groupe C', 'Lundi: 10h - 14h, Vendredi: 13h - 17h');

$professeur->addEmploiDuTemps($emploi1);
$professeur->addEmploiDuTemps($emploi2);
$professeur->addEmploiDuTemps($emploi3);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil du Professeur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <a href="#" class="logo"><span>P</span>rofesseur <span>G</span>uide</a>
        <nav class="navbar">
            <ul>
                <li><a href="#home">Accueil</a></li>
                <li><a href="#notes">Notes</a></li>
                <li><a href="#emploi">Emploi du temps</a></li>
                <li><a href="#logout">Déconnexion</a></li>
            </ul>
        </nav>
        <div class="fas fa-bars"></div>
    </header>

    <section id="home" class="home">
        <div class="row">
            <div class="images">
                <img src="./images/home.png" alt="Professeur Accueil">
            </div>
            <div class="content">
                <h1><span>Bienvenue</span>, Professeur!</h1>
                <p>Gérez vos classes, consultez les notes et l'emploi du temps des groupes.</p>
                <a href="#notes"><button class="button">Voir les notes</button></a>
            </div>
        </div>
    </section>

    <section id="notes" class="notes">
        <h1 class="heading">Notes de Classe</h1>
        <h3 class="title">Consulter et ajouter des notes pour vos élèves</h3>

        <div class="box-container">
            <?php
            // Affichage des notes du professeur
            $professeur->displayNotes();
            ?>
        </div>

        <div class="add-note">
            <h3>Ajouter une Note</h3>
            <form action="submit_note.php" method="post">
                <input type="text" placeholder="Nom de l'élève" name="student_name" required>
                <input type="text" placeholder="Matière" name="subject" required>
                <input type="number" placeholder="Note" name="grade" required min="0" max="20">
                <input type="submit" value="Ajouter la Note">
            </form>
        </div>
    </section>

    <section id="emploi" class="emploi">
        <h1 class="heading">Emploi du Temps</h1>
        <h3 class="title">Accédez à l'emploi du temps de chaque groupe</h3>

        <div class="box-container">
            <?php
            // Affichage des emplois du temps du professeur
            $professeur->displayEmploisDuTemps();
            ?>
        </div>
    </section>

    <section id="logout" class="logout">
        <h1 class="heading">Déconnexion</h1>
        <p>Êtes-vous sûr de vouloir vous déconnecter?</p>
        <a href="logout.php"><button class="button">Se Déconnecter</button></a>
    </section>

    <section class="footer">
        <div class="box">
            <h2 class="logo"><span>P</span>rofesseur <span>G</span>uide</h2>
            <p>Un outil pour gérer vos classes et améliorer votre enseignement.</p>
        </div>

        <div class="box">
            <h2 class="logo"><span>S</span>hare</h2>
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
        </div>

        <div class="box">
            <h2 class="logo"><span>L</span>inks</h2>
            <a href="#">Accueil</a>
            <a href="#">Notes</a>
            <a href="#">Emploi du temps</a>
            <a href="#">Déconnexion</a>
        </div>

        <h1 class="credit">Créé par <span>Website. Masters</span> - Tous droits réservés.</h1>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="main.js"></script>
</body>

</html>



