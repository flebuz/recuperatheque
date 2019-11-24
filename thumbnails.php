<?php

function make_thumb($src, $dest) {

  /* read the source image */
  $source_image = imagecreatefromjpeg($src);
  $width = imagesx($source_image);
  $height = imagesy($source_image);

  $desired_width = 400;
  $desired_height = 400;

  /* create a new, "virtual" image */
  $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

  /* copy source image at a resized size */
  // imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

  $virtual_image = imagecrop ( $source_image , ['x' => 0, 'y' => 0, 'width' => 400, 'height' => 400] );
  /* create the physical thumbnail image to its destination */
  imagejpeg($virtual_image, $dest);
}

?>
