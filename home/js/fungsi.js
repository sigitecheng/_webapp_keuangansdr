
	function rupiah(nilai){
		Number.prototype.ujungAngka =
		function(n, x) {
    		var re = '(\\d)(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\,' : '$') + ')';
   		   return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$1,'); //'$1.' adalah format pemisah setelah tiga angka muncul (menggunakan tanda titik)
        };

		var hargaProduk = [nilai], //25000000 adalah harga asli (sebelum format uang ditetapkan)
    	nn      = [2,  3,   2,    0,   2.3,     -4,   'abc',        2,  undefined],
    	xx      = [4, -1,   2,  3.5,  true,      4,       3,        3,          4];
			for (var i = 0, len = hargaProduk.length; i < len; i++) {
    		var angka = hargaProduk[i].ujungAngka(0); //ujungAngka(0) adalah format yang akan tampil dibelakang harga
		}
		return angka;
	}

	function tampil(view,hal,field,value){  // UNTUK CONTENT
		var tarik_file = "tengah.php?view="+view+"&hal="+hal+'&field='+field+'&kunci='+value; 

		$('#tengah').load(tarik_file);

		document.getElementById('cari').name=view; 
	    if(view.substr(0,5)=='tabel') { 
	    	document.getElementById('cari').hidden=false; 
	    	var judul = view.substr(5,15); 
		}
	    else{ document.getElementById('cari').hidden=true;
	    			if(view.substr(0,3)=='lap') {
	    				var judul = view.substr(4,15); 
	    			}else{ var judul = view.substr(6,15); }
		}

		if(view.substr(0,4)=='form')
		{
			var judul = view.substr(4,15);
			document.getElementById('judul_icon').innerHTML = judul.toUpperCase(); ;
	    	document.getElementById('icon').src = 'icon/'+judul+'.PNG' ;
		}else{
			document.getElementById('judul_icon').innerHTML = judul.toUpperCase(); ;
	    	document.getElementById('icon').src = 'icon/'+judul+'.PNG' ;
		}
	}

    function simpan(){   // ONCLICK BUTTON SIMPANPADA FORM
	$.post($("#formulir").attr("action"), $("#formulir :input").serializeArray(), 
	function(info) 
	{ });
	}  

	function cari_no_rek(gol){
	$.ajax({  
					type : 'POST',
					url : "fungsi/cari_kode_rek.php",
					data : { no_gol : gol },
							success : function(data){ 
			            			  document.getElementById('id').value=gol+data;  
	            	   	   } 
       			 });
	}
	function view_sisa_kas(id_perjanjian){  
	$.ajax({  
					type : 'POST',
					url : "fungsi/hitung_sisa_kas.php",
					data : { id_per : id_perjanjian,  },
							success : function(data){ 
			            			  document.getElementById('sisa_kas').value=data;  
			            			  document.getElementById('vsisa').innerHTML=rupiah(parseInt(data)); 
	            	   	   } 
       			 });
	}

	function view_sisa_kas_rekening(rekening_lancar,no_rek_didb,qty){
	$.ajax({  
					type : 'POST',
					url : "fungsi/hitung_sisa_kas_rekening.php",
					data : { no_rek : rekening_lancar },
							success : function(data){ 
										if(rekening_lancar==no_rek_didb){ 
											document.getElementById('sisa_kas').value=parseInt(data)+parseInt(qty);  
											document.getElementById('vsisa').innerHTML=rupiah(parseInt(data)+parseInt(qty)); 
										}
										else
										{	
				            			  document.getElementById('sisa_kas').value=data;  
				            			  document.getElementById('vsisa').innerHTML=rupiah(parseInt(data));
				            			}   
	            	   	   } 
       			 });
	}

	function konfir_hapus(manipulasi,id,reload,hal)  //ID YANG DIHAPUS ADA DI GET BARENG URL
    {
        pil = confirm("anda yakin ingin menghapus data '"+id+"' ?");
        if(pil==true)
            {  
            	$.ajax({
					type : 'POST',
					url : manipulasi,
					data : { hapus_id : id },
							complete : function(){ 
			            			   tampil(reload,hal,'','');  
	            	   	   } 
       			 }); 
            }
    }

    function val_angka(id){
	    if(isNaN((document.getElementById(id).value)))
	    {
	    	alert('Inputan harus Angka..');
    		document.getElementById(id).value ='0';
			document.getElementById(id).focus();
    	}
    }

    function val_pendapatan(edit_id){

    if(document.getElementById('no_bukti').value =='')
    	{   alert('No bukti belum diisi.. !');  
    		document.getElementById('no_bukti').focus();
	}	
	else if(document.getElementById('ket').value=='')
    	{ alert('Silahkan isi keterangan transaksi.. !'); 
    		document.getElementById('ket').value =  '';
			document.getElementById('ket').focus(); 
	}
    else if(document.getElementById('t_debit').innerHTML=='0' || document.getElementById('t_kredit').innerHTML=='0')
    	{ alert('Silahkan isi rincian transaksi.. !'); 
    		document.getElementById('rekening').value =  '';
			document.getElementById('rekening').focus(); 
	}	
	else if(document.getElementById('t_debit').innerHTML != document.getElementById('t_kredit').innerHTML)
		{ alert('TOTAL DEBIT dan KREDIT harus sama.. ! ');
	      document.getElementById('rekening').focus();  
	}
    else{	

			$.ajax({ 
				url:"man/m_pendapatan.php?edit_id="+edit_id , 
				type: 'POST',
				data: $("#formulir :input").serializeArray(),
								success : function(){ 
				            			   tampil('ttranspendapatan','','','');  
		            	   	   } 
			});
	   } 

    }

    function val_pengeluaran(edit_id){

    var D = document.getElementById('t_debit').innerHTML;
	var t_D = parseInt(D.split(',').join('')); //parseInt(D.replace(",",""));	
    	
    if(document.getElementById('no_bukti').value =='')
    	{   alert('No bukti belum diisi.. !');  
    		document.getElementById('no_bukti').focus();
	}	
	else if(document.getElementById('ket').value=='')
    	{ alert('Silahkan isi keterangan transaksi.. !'); 
    		document.getElementById('ket').value =  '';
			document.getElementById('ket').focus(); 
	}
    else if(document.getElementById('t_debit').innerHTML=='0' || document.getElementById('t_kredit').innerHTML=='0')
    	{ alert('Silahkan isi rincian transaksi.. !'); 
    		document.getElementById('rekening').value =  '';
			document.getElementById('rekening').focus(); 
	}	
	else if(document.getElementById('t_debit').innerHTML != document.getElementById('t_kredit').innerHTML)
		{ alert('TOTAL DEBIT dan KREDIT harus sama.. ! ');
	      document.getElementById('rekening').focus();  
	}
	else if( t_D > parseInt(document.getElementById('sisa_kas').value) )
		{ alert('Uang kas tidak mencukupi.. ! ');
	      document.getElementById('rekening').focus();  
	}
    else{	

			$.ajax({ 
				url:"man/m_pengeluaran.php?edit_id="+edit_id , 
				type: 'POST',
				data: $("#formulir :input").serializeArray(),
								success : function(){ 
				            			   tampil('ttranspengeluaran','','','');  
		            	   	   } 
			});
	   } 

    }

    function val_penyesuaian(edit_id){	
	if(document.getElementById('ket').value=='')
    	{ alert('Silahkan isi keterangan transaksi.. !'); 
    		document.getElementById('ket').value =  '';
			document.getElementById('ket').focus(); 
	}
    else if(document.getElementById('t_debit').innerHTML=='0' || document.getElementById('t_kredit').innerHTML=='0')
    	{ alert('Silahkan isi rincian transaksi.. !'); 
    		document.getElementById('rekening').value =  '';
			document.getElementById('rekening').focus(); 
	}	
	else if(document.getElementById('t_debit').innerHTML != document.getElementById('t_kredit').innerHTML)
		{ alert('TOTAL DEBIT dan KREDIT harus sama.. ! ');
	      document.getElementById('rekening').focus();  
	}
    else{	

			$.ajax({ 
				url:"man/m_penyesuaian.php?edit_id="+edit_id , 
				type: 'POST',
				data: $("#formulir :input").serializeArray(),
								success : function(){ 
				            			   tampil('ttranspenyesuaian','','','');  
		            	   	   } 
			});
	   } 

    }

    function val_pembelian_aset(edit_id){	


    var jumlah = parseInt(document.getElementById('qty').value);	
	var sisa = parseInt(document.getElementById('sisa_kas').value); //parseInt(D.replace(",",""));	

	if(document.getElementById('ket').value=='')
    	{ alert('Silahkan isi keterangan transaksi.. !'); 
    		document.getElementById('ket').value =  '';
			document.getElementById('ket').focus(); 
	}
	else if(document.getElementById('rekening1').value=='')
    	{ 
    		alert('Silahkan isi aset yang dibeli..');
    		document.getElementById('rekening1').focus();
	} 
	else if(document.getElementById('rekening2').value=='')
    	{ 
    		alert('Silahkan isi Uang kas yang digunakan..');
    		document.getElementById('rekening2').focus();
	} 
	else if(document.getElementById('qty').value=='0')
    	{ alert('Silahkan isi Jumlah transaksi.. !'); 
    		document.getElementById('qty').value =  '0';
			document.getElementById('qty').focus(); 
	}
	else if( jumlah > sisa )
		{ alert('Uang kas tidak mencukupi.. ! ');
	      document.getElementById('qty').focus();  
	}

    else{	

			$.ajax({ 
				url:"man/m_pembelian_aset.php?edit_id="+edit_id , 
				type: 'POST',
				data: $("#formulir :input").serializeArray(),
								success : function(){ 
				            			   tampil('ttranspembelianaset','','','');  
		            	   	   } 
			});
	   } 
    }

    function val_pemindahan_kas(edit_id){	


    var jumlah = parseInt(document.getElementById('qty').value);	
	var sisa = parseInt(document.getElementById('sisa_kas').value); //parseInt(D.replace(",",""));	

	if(document.getElementById('ket').value=='')
    	{ alert('Silahkan isi keterangan transaksi.. !'); 
    		document.getElementById('ket').value =  '';
			document.getElementById('ket').focus(); 
	}
	else if(document.getElementById('rekening1').value=='')
    	{ 
    		alert('Silahkan isi aset yang dibeli..');
    		document.getElementById('rekening1').focus();
	} 
	else if(document.getElementById('rekening2').value=='')
    	{ 
    		alert('Silahkan isi Uang kas yang digunakan..');
    		document.getElementById('rekening2').focus();
	} 
	else if(document.getElementById('qty').value=='0')
    	{ alert('Silahkan isi Jumlah transaksi.. !'); 
    		document.getElementById('qty').value =  '0';
			document.getElementById('qty').focus(); 
	}
	else if( jumlah > sisa )
		{ alert('Uang kas tidak mencukupi.. ! ');
	      document.getElementById('qty').focus();  
	}

    else{	

			$.ajax({ 
				url:"man/m_pemindahan_kas.php?edit_id="+edit_id , 
				type: 'POST',
				data: $("#formulir :input").serializeArray(),
								success : function(){ 
				            			   tampil('ttranspemindahankas','','','');  
		            	   	   } 
			});
	   } 
    }

    function val_rekening(edit_id){
	    $('#formulir').submit( function(e) {
		$.ajax({ 
			url:"man/m_rekening.php?edit_id="+edit_id , 
			type: 'POST',
			data: new FormData(this),
			processData: false,
			contentType: false,
								complete : function(){ 
				            			   tampil('tabelrekening','','','');  
		            	   	   } 
			});
		e.preventDefault();
		});
    }

    function val_perjanjian(edit_id){
	    $('#formulir').submit( function(e) {
		$.ajax({ 
			url:"man/m_perjanjian.php?edit_id="+edit_id , 
			type: 'POST',
			data: new FormData(this),
			processData: false,
			contentType: false,
								complete : function(){ 
				            			   tampil('tabelperjanjian','','','');  
		            	   	   } 
			});
		e.preventDefault();
		});
    }

    function val_investor(edit_id){
	    $('#formulir').submit( function(e) {
		$.ajax({ 
			url:"man/m_investor.php?edit_id="+edit_id , 
			type: 'POST',
			data: new FormData(this),
			processData: false,
			contentType: false,
								complete : function(){ 
				            			   tampil('tabelinvestor','','','');  
		            	   	   } 
			});
		e.preventDefault();
		});
    }

    function val_pimpinan(edit_id){
	    $('#formulir').submit( function(e) {
		$.ajax({ 
			url:"man/m_pimpinan.php?edit_id="+edit_id , 
			type: 'POST',
			data: new FormData(this),
			processData: false,
			contentType: false,
								complete : function(){ 
				            			   tampil('tabelpimpinan','','','');  
		            	   	   } 
			});
		e.preventDefault();
		});
    }

    function val_admin(edit_id){
	    $('#formulir').submit( function(e) {
		$.ajax({ 
			url:"man/m_admin.php?edit_id="+edit_id , 
			type: 'POST',
			data: new FormData(this),
			processData: false,
			contentType: false,
								complete : function(){ 
				            			   tampil('tabeladmin','','','');  
		            	   	   } 
			});
		e.preventDefault();
		});
    }

    function val_bendahara(edit_id){
	    $('#formulir').submit( function(e) {
		$.ajax({ 
			url:"man/m_bendahara.php?edit_id="+edit_id , 
			type: 'POST',
			data: new FormData(this),
			processData: false,
			contentType: false,
								complete : function(){ 
				            			   tampil('tabelbendahara','','','');  
		            	   	   } 
			});
		e.preventDefault();
		});
    }  