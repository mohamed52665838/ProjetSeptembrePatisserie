<?php
include_once __DIR__ . '/controller/UserController.php';
include_once __DIR__ . '/model/User.php';


$usersController = new UserController();
$message = "";

// --- Suppression d'un utilisateur ---
if (isset($_POST['delete_id'])) {
    try {
        $usersController->delete($_POST['delete_id']);
        $message = "✅ Utilisateur supprimé avec succès !";
    } catch (Exception $e) {
        $message = "❌ Erreur lors de la suppression : " . $e->getMessage();
    }
}



// --- Récupérer la liste des utilisateurs ---
$users = $usersController->list();
?>
 <?include_once __DIR__ . './components/bodywrapper/bodytop.php' ?>
  <h1>Liste des Utilisateurs</h1>

  <?php if (!empty($message)) : ?>
    <div class="msg <?= strpos($message, 'Erreur') === false ? 'success' : 'error' ?>">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
      <tr>
        <td><?= htmlspecialchars($user['nom']) ?></td>
        <td><?= htmlspecialchars($user['prenom']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['role']) ?></td>
        <td>
          <a href="?edit_id=<?= $user['id'] ?>">Modifier</a>
          <form method="post" action="" style="display:inline;">
            <input type="hidden" name="delete_id" value="<?= $user['id'] ?>">
            <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">Supprimer</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h2><?= $editUser ? "Modifier l'utilisateur" : "Ajouter un Utilisateur" ?></h2>
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

 <?include_once __DIR__ . './components/bodywrapper/bodybottom.php' ?>
