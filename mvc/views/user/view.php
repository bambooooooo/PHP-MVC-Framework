<div class="container">
  <div class="row pt-2">
    <div class="col-md-3">
      <img src="<?=URL;?>public/images/avatar/<?=$this->userData['avatar']?>" alt="" width="220px">
      <h3><?=$this->userData['nickname']?></h3>

      <?=$this->userData['first_name'].' '.$this->userData['last_name']?><br>
      <?=$this->userData['date_join']?><br>
      <?php
        $ses = Session::get('userSession');
        if( $this->userData['user_id'] == $ses['user_id'] ){
          echo'<a href="'.URL.'user/edit" class="btn btn-info">edit profile</a>';
        }

      ?>

    </div>
    <div class="col-md-9">
      <div class="display-4">Activity</div>
      <section>
        <div class="my-2 ml-3">
          <strong>september 2018</strong>
        </div>
        <ul>
          <li class="list-group-item">Email confirmed</li>
          <li class="list-group-item">Joined App</li>
        </ul>
      </section>
    </div>
  </div>

</div>
