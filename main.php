<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
  $diahoje = date ("d");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_URL,"https://epg-api.video.globo.com/programmes/1337?date=2020-07-".$diahoje);
  $result=curl_exec($ch);
  curl_close($ch);
  $result=json_decode($result);
  $horaacessada = date("h:i");
  include('header.php');

 
?>


<br><br><br>
<section id="mainadmin">
 <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
						        <h2>Programação<b> RPC </b></h2>
                    <h4>Programa atual: <b> <?php  echo $_SESSION['programaatual'] ?> </b> </h4>
					</div>
                </div>
            </div>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">Título</th>
                  <th scope="col">Descrição</th>
                  <th scope="col">Início</th>
                  <th scope="col">Fim</th>
                  <th scope="col">IdPrograma</th>
                </tr>
                </thead>
                <tbody>
                    
					<?php
                        foreach ($result->programme->entries as $entrie) {
                          
					?>
					<tr>
                        <td data-label="Título">
                            <?php
                                echo $entrie->title . "<br>";
                            ?>
                        </td>
                        <td data-label="Descrição">
                            <?php
                                echo $entrie->description . "<br>";
                            ?>
                        </td>
                        <td data-label="Início">
                            <?php
                                $horafim = $entrie->human_end_time;
                                $convert = strtotime($horafim);
                                $horafimreal = date('H:i',$convert);
                                $horainicio = $entrie->human_start_time;
                                $convert = strtotime($horainicio);
                                $horainicioreal = date('H:i',$convert);
                                echo $horainicioreal . "<br>";
                                if (($horaacessada > $horainicioreal) && ($horaacessada) < $horafimreal) {
                                  $_SESSION['programaatual'] = $entrie->title;
                                }
                            ?>
                        </td>
                        <td data-label="Fim">
                            <?php
                                
                                echo $horafimreal . "<br>";
                            ?>
                        </td>
                        <td data-label="IdPrograma">
                            <?php
                                echo $entrie->media_id . "<br>";
                            ?>
                        </td>
						<?php
                                }
                            ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </section>
                            
  
<?php
 
    include('footer.php');
?>