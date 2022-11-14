


function formatUang(angka) // memformat uang menjadi 200,000
{
	var input = angka.toString();   // toString merubah int ke string
	var angka = -1 ;
	var cari = input.search("-");   // melakuakan pencarian pada string input (-) jika di temukan hasil 0 dn jika tidak di temukan -1;
	
	if(parseInt(cari) == parseInt(angka))
		{
			var	number_string = input.toString(),
				sisa 	= number_string.length % 3,
				rupiah 	= number_string.substr(0, sisa),
				ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
		
				if (ribuan) 
					{
						separator = sisa ? ',' : '';
						rupiah += separator + ribuan.join(',');
					}

					// Cetak hasil
				return rupiah; 
		}
	else
		{
			var ubah = input.replace('-','');
		
			var	number_string = ubah.toString(),
				sisa 	= number_string.length % 3,
				rupiah 	= number_string.substr(0, sisa),
				ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
		
				if (ribuan) 
					{
						separator = sisa ? ',' : '';
						rupiah += separator + ribuan.join(',');
					}

					// Cetak hasil
				return '-'+rupiah; 
			
		}
		
	
}	
	
	
function menghilangkanKoma(ambil)
{
	

	
	var input = ambil.toString();
	var angka = -1;
	var cari = input.search(",");       //jika ada tanda , maka menghasilkan angka 1, jika tdk ada tanda "," menghasilkan -1
	
	if(parseInt(cari) == parseInt(angka))
	{
			if(ambil >= 1)
			{
				return data = ambil;
	
			}
		else
			{
				return data = "0";
			}
		
		
	}
	else
	{

		var array = input.split(",");  			//split(",") memisahkan berdasarkan tanda ,
		for(i=0; i < array.length; i++)
		{
			parseInt(array[i]); //hasil array di ubah ke int
		}
	
		return array.join('');
	
	
	}
}


