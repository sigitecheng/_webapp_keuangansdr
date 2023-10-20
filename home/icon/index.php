<link rel="stylesheet" type="text/css" href="css/style.css">

<link rel="stylesheet" href="js/jquery-ui.css" />
<script src="js/jquery-2.0.3.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/fungsi.js"></script>

<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<div id="home">
  <div id="header">
    <div id="akun"> <a href="logout.php"><img src="icon/logout.PNG" height="40"> </a></div>
	
    <div id="hiasan"></div>
  </div>
  
  <div id="isi">
  <div id="shortcut">
    <div id="real_time"></div>
    <div id="shrtct">
      <ul>
	  			  		              </ul>
                  <ul>
	  		<li><a href="#" onclick="tampil('lap_transaksi','','','')" >Transaksi</a></li>
	  		<li><a href="#" onclick="tampil('lap_jurnal','','','')" >Jurnal </a></li>
	  		<li><a href="#" onclick="tampil('lap_buku_besar','','','')" >Buku Besar</a></li>
	  		<li><a href="#" onclick="tampil('lap_neraca_lajur','','','')" >Neraca Lajur</a></li>
	  		<li><a href="#" onclick="tampil('lap_neraca','','','')" >Neraca</a></li>
	  		<li><a href="#" onclick="tampil('lap_rugilaba','','','')" >Rugi - Laba</a></li>
      </ul>
            </div>
  </div>
  
  <div id="content">
  <div id="menu">
    <ul >
    </ul> 
	
  </div>
   
  <div class="halamandinamis">
    
   <img id="icon" src="" height="80" width="80" style="float:right; margin-right:30;" /> 
   <font face="candara" > <h2><label  style="float:right; margin-right:10;" id="judul_icon">   </label></h2></font><br>
   <input style="margin-left:25px;" type="text" id='cari' hidden='true' name='admin' value="" onkeyup="tampil(this.name,'','nama',this.value)" placeholder='Cari nama..' />
   </br></br>
 	 <div id="tengah">
		
	</div>
  </div>

  </div>
  <div id="foother"></div>
  </div>
</div>



