<?php
    include_once __DIR__ . '/../../controller/UserController.php';
    $usersController = new UserController();
    $users = $usersController->list();
?>

 <?php include_once __DIR__ . '/../../components/bodywrapper/bodytop.php' ?>

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
        <?php if(empty($users->fetchAll(PDO::FETCH_ASSOC))) { ?>
        <tr>
          <td colspan="6" style="text-align: center; color: #7f8c8d;">Aucun utilisateur trouvé.</td>
        <?php }?>
      <?php while ($user = $users->fetch(PDO::FETCH_ASSOC)) { ?>
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
      <?php } ?>
    </tbody>
  </table>

  <?include_once __DIR__ . '../../components/bodywrapper/bodybottom.php' ?>
