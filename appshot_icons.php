<?php

include('src/abeautifulsite/SimpleImage.php');

class appShotIcons {

	public function runAppShot() {

		// Image Manipulation
		$this->manipulateImage();

		// Zip Images
		$this->generateZip();

		// Email download link
		$this->emailUser();

	}

	private function manipulateImage() {

		global $randInt; 
		$randInt = rand(1000000000, 9999999999);

		mkdir("appshots/$randInt");
		mkdir("appshots/$randInt/3.5");
		mkdir("appshots/$randInt/4.0");
		mkdir("appshots/$randInt/4.7");
		mkdir("appshots/$randInt/5.5");

		$totalCount = count($_FILES['file']['name']);
		$imageCount = 0;

		$imageCheck = $_FILES['file']['name'][0];

			while ($imageCount<$totalCount) {

				$image_name = $_FILES['file']['name'][$imageCount];
				$image_type = $_FILES['file']['type'][$imageCount];
				$image_size = $_FILES['file']['size'][$imageCount];
				$image_tmp_name = $_FILES['file']['tmp_name'][$imageCount];

				move_uploaded_file($image_tmp_name, "appshots/$randInt/upload_$image_name");

				// 3.5 inch

				$img35 = new abeautifulsite\SimpleImage('images/3.5.png');
				$img36 = new abeautifulsite\SimpleImage("appshots/$randInt/upload_$image_name");
				$img36->resize(756, 1338);

				$img35->overlay($img36, 'center', 1, 0, 0);
				$img35->resize(640, 960);
				$img35->save("appshots/$randInt/3.5/$imageCount-3.5.jpg", 90);

				// 4.0 inch

				$img40 = new abeautifulsite\SimpleImage("appshots/$randInt/upload_$image_name");
				$img40->resize(640, 1136);
				$img40->save("appshots/$randInt/4.0/$imageCount-4.0.jpg", 90);

				// 4.7 inch

				$img47 = new abeautifulsite\SimpleImage("appshots/$randInt/upload_$image_name");
				$img47->resize(750, 1334);
				$img47->save("appshots/$randInt/4.7/$imageCount-4.7.jpg", 90);

				// 5.5 inch

				$img55 = new abeautifulsite\SimpleImage("appshots/$randInt/upload_$image_name");
				$img55->resize(1242, 2208);
				$img55->save("appshots/$randInt/5.5/$imageCount-5.5.jpg", 90);

				imagedestroy($img35);
				imagedestroy($img36);
				imagedestroy($img40);
				imagedestroy($img47);
				imagedestroy($img55);

				$imageCount++;

			}	

	}

	private function generateZip() {

		global $randInt;

		$totalCount = count($_FILES['file']['name']);
		echo $totalCount;
		$imageCount = 0;

		$imageFiles = array();

		while ($imageCount<$totalCount) {

			array_push($imageFiles, "appshots/$randInt/3.5/$imageCount-3.5.jpg");
			array_push($imageFiles, "appshots/$randInt/4.0/$imageCount-4.0.jpg");
			array_push($imageFiles, "appshots/$randInt/4.7/$imageCount-4.7.jpg");
			array_push($imageFiles, "appshots/$randInt/5.5/$imageCount-5.5.jpg");

			$imageCount++;

		}
		
		$zip = new ZipArchive();
		$zip->open("appshots/AppShotsGenerated_".$randInt.".zip", ZipArchive::CREATE);

		foreach($imageFiles as $file) {

			$zip->addFile($file);

		}

		$zip->close();

	}

	private function emailUser() {

		global $randInt;

		$emailTo = $_POST["email"];

		$subject = "AppShots Generated";

		$body = "http://appstorescreenshots.com/appshots/AppShotsGenerated_".$randInt.".zip";

		$headers = "From: admin@appstorescreenshots.com";

		if(mail($emailTo, $subject, $body, $headers)){
		}else {
			echo "Failure";
		}		

	}

}

?>