<div class="container">
  <div class="row pt-2">
    <div class="col-md-3">
      <img src="<?=URL;?>public/images/avatar/<?=$this->userData['avatar']?>" alt="" width="220px">
      <form action="<?=URL?>user/changeAvatar" method="post" enctype="multipart/form-data">
        <label for="file-upload" class="file-upload-label my-2">
            <i class="fa fa-cloud-upload"></i> Choose file
        </label>
        <input id="file-upload"  type="file" name="avatar" style="display:none">
        <input type="submit" class="btn btn-primary" value="Upload" style="width:100%">
        <input type="hidden" name="formName" value="avatar">
      </form>
      <div class="login-error">
        <?php
          if(isset($this->uploadError) && !empty($this->uploadError)){
            foreach ($this->uploadError as $key => $value) {
              echo'<strong>'.$value.'</strong><br>';
            }
          }
        ?>
      </div>
    </div>
    <div class="col-md-9">
      <div class="display-4">Edit Data</div>
      <form action="<?=URL?>user/editDo" method="post">
        <table class="table-borderless user-data-table">
          <tr><td>nickname</td><td><?=$this->userData['nickname']?></td></tr>
          <tr><td>first name</td><td><input type="text" name="first_name" value="<?=$this->userData['first_name']?>"></td></tr>
          <tr><td>last name</td><td><input type="text" name="last_name" value="<?=$this->userData['last_name']?>"></td></tr>
          <tr>
            <td></td><td><input type="submit" class="btn btn-success mt-2" value="Save changes"></td>
          </tr>
        </table>
        <input type="hidden" name="formName" value="editUser">
      </form>
    </div>
  </div>
</div>
