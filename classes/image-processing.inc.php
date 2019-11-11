<?php
	class ImageProcessing
	{
		public function getSticker($sticker)
		{
			if ($sticker == "sticker01")
				$value = "assets/images/app/sticker01.png";
			elseif ($sticker == "sticker02")
				$value = "assets/images/app/sticker02.png";
			elseif ($sticker == "sticker03")
				$value = "assets/images/app/sticker03.png";
			elseif ($sticker == "sticker04")
				$value = "assets/images/app/sticker04.png";

			return $value;
		}

		public function mergeImages($image, $sticker)
		{
			$image1 = $image;
			$image2 = $sticker;

			list($width, $height) = getimagesize($image2);

			$image1 = imagecreatefromstring(file_get_contents($image1));
			$image2 = imagecreatefromstring(file_get_contents($image2));

			imagecopymerge($image1, $image2, 0, 400, 0, 0, $width, $height, 100);
			header('Content-Type: image/jpeg');
			imagejpeg($image1, $image, 80);

			imagedestroy($image1);
			header("Location: post.php");
		}
	}
?>
