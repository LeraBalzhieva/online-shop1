<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];

    $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
    $stmt = $pdo->query("SELECT * FROM users WHERE id = $userId");
    $user = $stmt->fetch();
} else {
    header("Location: login");
}?>

<form action="editProfile" method="POST" class="form-example">
  <div class="form-example">
    <label for="name">Введите новое имя: </label>
      <?php if (isset($errors['name'])):  ?>
          <label style="color: red"><?php echo $errors['name'];?></label>
      <?php endif; ?>

      <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>" />
  </div>
  <div class="form-example">
    <label for="email">Введите новый email: </label>
      <?php if (isset($errors['email'])):  ?>
          <label style="color: red"><?php echo $errors['email'];?></label>
      <?php endif; ?>
    <input type="email" name="mail" id="email" value="<?php echo $user['email']; ?>" />
  </div>
  <div class="form-example">
    <input type="submit" value="Изменить" />
  </div>
</form>
<style>
form.form-example {
display: table;
}

div.form-example {
display: table-row;
}

label,
input {
display: table-cell;
margin-bottom: 10px;
}

label {
padding-right: 10px;
}
</style>