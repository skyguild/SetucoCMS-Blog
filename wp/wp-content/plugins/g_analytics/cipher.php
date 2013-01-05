<?php
// RC4
class cipher {
	private $key;
	
	function setKey($key) {
		$temp_arr = range(0,255);
		$len = strlen($key);
		$ascii = array();
		
		for ($i = 0 ; $i < 256 ; $i++) {
			$ascii[$i] = ord(substr($key, $i % $len, 1));
		}
		
		$j = 0;
		for ($i = 0 ; $i < 256 ; $i++) {
			$j = ($j + $temp_arr[$i] + $ascii[$i]) % 256;
			$temp = $temp_arr[$i];
			$temp_arr[$i] = $temp_arr[$j];
			$temp_arr[$j] = $temp;
		}
		$this->key = $temp_arr;
	}
	
	function getCrypt($data) {
		$key = $this->key;
		$len = strlen($data);
		$reslt ="";
		
		$i = 0;
		$j = 0;
		for ($k = 0 ; $k < $len ; $k++) {
			$i = ($i + 1) % 256;
			$chr_key_i = substr($key, $i, 1);
			$j = ($j + $chr_key_i) % 256;
			
			$chr_key_j = substr($key, $j, 1);
			
			$temp = $chr_key_i;
			$chr_key_i = $chr_key_j;
			$chr_key_j = $temp;
			$t = ($chr_key_i + $chr_key_j) % 256;
			$reslt .= chr(ord(substr($data, $k, 1)) ^ $key[$t]);
		}
		
		return $reslt;
	}
}

?>