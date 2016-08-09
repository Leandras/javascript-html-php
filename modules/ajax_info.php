<?php
  include_once('data.php');
  include_once('sessions/session_map.php');
  include_once('sessions/session_login.php');
  include_once('consts.php');

  if($_GET){
  	if(isset($_GET['score'])){
  		$score = $_GET['score'];
  		$scores = adat_betoltes($SCORES);
      $usc = adat_betoltes($USERS_SCORES);

  		
  		$currentlevel = $_SESSION['currentlevel'];
  		$highestscore = $scores[$currentlevel]['score'];	

      $currentuser = $_SESSION['username'];

    if($score != 0){
        
        $talalat = false;
        foreach($usc as $key => $u) {
          if($u['level_id'] == $currentlevel && $u['user'] == $currentuser){
            $talalat = true;
            if($u['score'] < $score){
              $usc[$key]['score'] = $score;
              adat_mentes($USERS_SCORES, $usc);
            }
          }
        }
        if(!$talalat){
          $usc[time()] = array(
            'user' => $currentuser,
            'level_id' => $currentlevel,
            'score' => $score
          );
        }

        foreach ($scores as $key => $value) {
          if($key == $currentlevel){
            if($value['score'] < $score){
              $scores[$key]['name'] = $currentuser;
              $scores[$key]['score'] = $score;
              adat_mentes($SCORES, $scores);
            }
          }
        }
        adat_mentes($USERS_SCORES, $usc);
      }
  	}
  }


?>