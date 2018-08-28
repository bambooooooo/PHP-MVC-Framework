<div class="text-center">
  <?=Session::get('confirmAlert'); ?>
  <?php Session::remove('confirmAlert'); ?>
</div>
<div style="position:absolute; width:100%; height:100%">
<div class="container" style="height:100%">
  <div class="row justify-content-center ">
    <div class="col-sm-6" style="position:absolute; top:50%; transform:translateY(-60%)">
      <div class="text-center">
        <img src="<?=URL;?>public/images/logo.svg" alt="logo" width="250">
        <p>Simple mvc framework to making websites.</p>
        <a href="<?=URL;?>exaple" class="btn btn-outline-info mt-2">Download</a>
        <a href="<?=URL;?>docs" class="btn btn-success mt-2">Documentation</a>
      </div>

    </div>
  </div>
</div>
</div>
<div class="earth">
  <div class="ocean">
    <div class="wave"></div>
    <div class="wave"></div>
  </div>
</div>
