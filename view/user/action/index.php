
<?php
// --- Ajout ou Mise à jour d'un utilisateur ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_id'])) {
    try {
        if (isset($_POST['update_id'])) {
            // UPDATE
            $updatedUser = User::fromArray($_POST);
            if ($usersController->updateUser($updatedUser, $_POST['update_id'])) {
                // Redirection après update pour vider le formulaire
                header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
                exit;
            }
        } else {
            // INSERT
            $newUser = User::fromArray($_POST);
            if ($usersController->addUser($newUser)) {
                $message = "✅ Utilisateur ajouté avec succès !";
            }
        }
    } catch (Exception $e) {
        $message = "❌ Erreur : " . $e->getMessage();
    }
} 


// --- Préparer un utilisateur à modifier ---
$editUser = null;
if (isset($_GET['edit_id'])) {
    foreach ($usersController->list() as $u) {
        if ($u['id'] == $_GET['edit_id']) {
            $editUser = $u;
            break;
        }
    }
}
?>


<?php include_once __DIR__ . '/../../../components/bodywrapper/bodytop.php' ?>

<form method="post" action="">
    <?php if ($editUser): ?>
      <input type="hidden" name="update_id" value="<?= $editUser['id'] ?>">
    <?php endif; ?>

    <label>Nom :</label>
    <input type="text" name="nom" required value="<?= $editUser['nom'] ?? '' ?>">

    <label>Prénom :</label>
    <input type="text" name="prenom" required value="<?= $editUser['prenom'] ?? '' ?>">

    <label>Username :</label>
    <input type="text" name="username" required value="<?= $editUser['username'] ?? '' ?>">

    <label>Email :</label>
    <input type="email" name="email" required value="<?= $editUser['email'] ?? '' ?>">

    <?php if (!$editUser): ?>
      <label>Mot de passe :</label>
      <input type="password" name="password" required>
    <?php endif; ?>

    <label>Role :</label>
    <select name="role" required>
      <?php
        $roles = ['client', 'preparateur', 'admin'];
        foreach ($roles as $role) {
          $selected = ($editUser && $editUser['role'] == $role) ? "selected" : "";
          echo "<option value='$role' $selected>" . ucfirst($role) . "</option>";
        }
      ?>
    </select>

    <button type="submit"><?= $editUser ? "Mettre à jour" : "Ajouter" ?></button>
  </form>

  <?php include_once __DIR__ . '/../../../components/bodywrapper/bodybottom.php' ?>
