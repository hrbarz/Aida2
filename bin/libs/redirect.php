<?php

		// redireccionamiento
		function redirect($url, $js = false, $time=false)
		{
			if($js)
			{
				if($time)
				{
					echo "<script> setTimeout('window.location.href=\'". $url ."\'',". $time ."); </script>";
				}
				else
				{	
					echo "<script> window.location.href='". $url ."' </script>";
				}
			}
			else
			{
				header('Location:'. $url);
			}
			
			die();
		}


?>