<?php
// var_dump($model);
?>

<h1>Register</h1>

<form action="" method="post">
  <div class="mb-3">
    <label>Firstname</label>
    <input type="text" name="firstname" value="<?= $model->firstname ?? '' ?>"
     class="form-control <?= $model->validator->hasError('firstname') ? 'is-invalid' : ''; ?>"> 
    <div class="invalid-feedback">
      <?= $model->validator->getFirstError('firstname'); ?>
    </div> 
  </div>
  <div class="mb-3">
    <label>Lastname</label>
    <input type="text" name="lastname" value="<?= $model->lastname ?? '' ?>"
    class="form-control <?= $model->validator->hasError('lastname') ? 'is-invalid' : ''; ?>"> 
    <div class="invalid-feedback">
      <?= $model->validator->getFirstError('lastname'); ?>
    </div>
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" value="<?= $model->email ?? '' ?>"
    class="form-control <?= $model->validator->hasError('email') ? 'is-invalid' : ''; ?>"> 
    <div class="invalid-feedback">
      <?= $model->validator->getFirstError('email'); ?>
    </div>
  </div> 
  <div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" value="<?= $model->password ?? '' ?>"
    class="form-control <?= $model->validator->hasError('password') ? 'is-invalid' : ''; ?>"> 
    <div class="invalid-feedback">
      <?= $model->validator->getFirstError('password'); ?>
    </div>
  </div>
  <div class="mb-3">
    <label>Confirm Password</label>
    <input type="password" name="confirmPassword" value="<?= $model->confirmPassword ?? '' ?>"
    class="form-control <?= $model->validator->hasError('confirmPassword') ? 'is-invalid' : ''; ?>"> 
    <div class="invalid-feedback">
      <?= $model->validator->getFirstError('confirmPassword'); ?>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>