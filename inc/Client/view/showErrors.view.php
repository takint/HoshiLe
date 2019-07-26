<main>
  <div class="py-4">
    <div class="container">
      <?php foreach ($errors as $error) { ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php } ?>
    </div>
  </div>
</main>
