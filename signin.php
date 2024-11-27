<?php
class Registration {
    // Propriétés
    private $firstName;
    private $username;
    private $email;
    private $password;
    private $confirmPassword;

    private $firstNameErr;
    private $usernameErr;
    private $emailErr;
    private $passwordErr;
    private $confirmPasswordErr;

    // Constructeur pour initialiser les valeurs par défaut
    public function __construct() {
        $this->firstName = "";
        $this->username = "";
        $this->email = "";
        $this->password = "";
        $this->confirmPassword = "";
        $this->firstNameErr = "";
        $this->usernameErr = "";
        $this->emailErr = "";
        $this->passwordErr = "";
        $this->confirmPasswordErr = "";
    }

    // Fonction pour traiter le formulaire
    public function handleForm() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Appeler les méthodes de validation
            $this->validateFirstName();
            $this->validateUsername();
            $this->validateEmail();
            $this->validatePassword();
            $this->validateConfirmPassword();

            // Si tout est validé, on affiche un message de succès
            if (empty($this->firstNameErr) && empty($this->usernameErr) && empty($this->emailErr) && empty($this->passwordErr) && empty($this->confirmPasswordErr)) {
                echo "<p>Formulaire soumis avec succès !</p>";
            }
        }
    }

    // Validation du prénom
    private function validateFirstName() {
        if (empty($_POST["firstName"])) {
            $this->firstNameErr = "Le prénom est requis.";
        } else {
            $this->firstName = $this->test_input($_POST["firstName"]);
        }
    }

    // Validation du nom d'utilisateur
    private function validateUsername() {
        if (empty($_POST["username"])) {
            $this->usernameErr = "Le nom d'utilisateur est requis.";
        } else {
            $this->username = $this->test_input($_POST["username"]);
        }
    }

    // Validation de l'email
    private function validateEmail() {
        if (empty($_POST["email"])) {
            $this->emailErr = "L'email est requis.";
        } else {
            $this->email = $this->test_input($_POST["email"]);
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->emailErr = "Format d'email invalide.";
            }
        }
    }

    // Validation du mot de passe
    private function validatePassword() {
        if (empty($_POST["password"])) {
            $this->passwordErr = "Le mot de passe est requis.";
        } else {
            $this->password = $this->test_input($_POST["password"]);
            if (strlen($this->password) < 8) {
                $this->passwordErr = "Le mot de passe doit comporter au moins 8 caractères.";
            }
        }
    }

    // Validation de la confirmation du mot de passe
    private function validateConfirmPassword() {
        if (empty($_POST["confirmPassword"])) {
            $this->confirmPasswordErr = "La confirmation du mot de passe est requise.";
        } else {
            $this->confirmPassword = $this->test_input($_POST["confirmPassword"]);
            if ($this->password !== $this->confirmPassword) {
                $this->confirmPasswordErr = "Les mots de passe ne correspondent pas.";
            }
        }
    }

    // Fonction de nettoyage des données
    private function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data); // Prévention des attaques XSS
        return $data;
    }

    // Méthodes pour obtenir les valeurs et les erreurs
    public function getFirstName() {
        return $this->firstName;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getConfirmPassword() {
        return $this->confirmPassword;
    }

    public function getFirstNameErr() {
        return $this->firstNameErr;
    }
    public function getUsernameErr() {
        return $this->usernameErr;
    }
    public function getEmailErr() {
        return $this->emailErr;
    }
    public function getPasswordErr() {
        return $this->passwordErr;
    }
    public function getConfirmPasswordErr() {
        return $this->confirmPasswordErr;
    }
}

// Inclusion de la classe Registration
include('Registration.php');

// Création d'un objet Registration
$registration = new Registration();

// Traitement du formulaire
$registration->handleForm();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Formulaire d'inscription</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Prénom -->
            <label for="firstName">Prénom :</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo $registration->getFirstName(); ?>" required>
            <span class="error"><?php echo $registration->getFirstNameErr(); ?></span>

            <!-- Nom d'utilisateur -->
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" value="<?php echo $registration->getUsername(); ?>" required>
            <span class="error"><?php echo $registration->getUsernameErr(); ?></span>

            <!-- Email -->
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo $registration->getEmail(); ?>" required>
            <span class="error"><?php echo $registration->getEmailErr(); ?></span>

            <!-- Mot de passe -->
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <span class="error"><?php echo $registration->getPasswordErr(); ?></span>

            <!-- Confirmation du mot de passe -->
            <label for="confirmPassword">Confirmer le mot de passe :</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <span class="error"><?php echo $registration->getConfirmPasswordErr(); ?></span>

            <input type="submit" value="S'inscrire">
        </form>
    </div>
</body>
</html>

