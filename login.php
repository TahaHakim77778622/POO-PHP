<?php
session_start();

class Login {
    private $username;
    private $password;
    private $usernameErr;
    private $passwordErr;
    private $validUsername = "admin";
    private $validPassword = "password123";

    public function __construct() {
        $this->username = "";
        $this->password = "";
        $this->usernameErr = "";
        $this->passwordErr = "";
    }

    // Fonction pour valider les données
    public function validateInput() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validation du nom d'utilisateur
            if (empty($_POST["username"])) {
                $this->usernameErr = "Le nom d'utilisateur est requis.";
            } else {
                $this->username = $this->test_input($_POST["username"]);
            }

            // Validation du mot de passe
            if (empty($_POST["password"])) {
                $this->passwordErr = "Le mot de passe est requis.";
            } else {
                $this->password = $this->test_input($_POST["password"]);
            }

            // Si les champs sont valides, vérifier les identifiants
            if (empty($this->usernameErr) && empty($this->passwordErr)) {
                $this->checkCredentials();
            }
        }
    }

    // Vérification des identifiants
    private function checkCredentials() {
        if ($this->username === $this->validUsername && $this->password === $this->validPassword) {
            $_SESSION['username'] = $this->username;
            header("Location: dashboard.php");
            exit();
        } else {
            $this->passwordErr = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }

    // Nettoyage des données
    private function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Getter pour les erreurs
    public function getUsernameErr() {
        return $this->usernameErr;
    }

    public function getPasswordErr() {
        return $this->passwordErr;
    }

    // Getter pour les valeurs des champs
    public function getUsername() {
        return $this->username;
    }
    
    public function getPassword() {
        return $this->password;
    }
}

// Instanciation et validation
$login = new Login();
$login->validateInput();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; }
        .form-container { max-width: 400px; margin: 100px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        input[type="submit"] { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        input[type="submit"]:hover { background-color: #45a049; }
        .error { color: red; font-size: 12px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Connexion</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" value="<?php echo $login->getUsername(); ?>" required>
            <span class="error"><?php echo $login->getUsernameErr(); ?></span>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <span class="error"><?php echo $login->getPasswordErr(); ?></span>

            <input type="submit" value="Se connecter">
        </form>
        <p>Pas encore inscrit ? <a href="signup.php">Créer un compte</a></p>
    </div>
</body>
</html>
