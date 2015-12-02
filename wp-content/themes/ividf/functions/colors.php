<?php

function om_rgb2rgb($rgba) {
	$rgba=preg_replace('/\s/', '', $rgba);
	if(preg_match('#rgb\(([0-9]+),([0-9]+),([0-9]+)\)#',$rgba,$m)) {
		return array($m[1], $m[2], $m[3]);
	} else {
		return false;
	}
}

function om_rgba2rgba($rgba) {
	$rgba=preg_replace('/\s/', '', $rgba);
	if(preg_match('#rgba\(([0-9]+),([0-9]+),([0-9]+),([0-9\.]+)\)#',$rgba,$m)) {
		return array($m[1], $m[2], $m[3], $m[4]);
	} else {
		return false;
	}
}

function om_hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);
	
	if (strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	}
	else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	
	return array($r, $g, $b);
}

function om_rgb2hex($rgb) {
	$hex = str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

	return $hex;
}

function om_rgb2hsl($rgb) {
  $r = $rgb[0] / 255;
  $g = $rgb[1] / 255;
  $b = $rgb[2] / 255;

  $max = max($r, $g, $b);
  $min = min($r, $g, $b);

  $l = ($max + $min) / 2;

  if ($max == $min) {
      $h = $s = 0;
  } else {
      $d = $max - $min;
      $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
      switch($max){
          case $r: $h = ($g - $b) / $d + ($g < $b ? 6 : 0); break;
          case $g: $h = ($b - $r) / $d + 2; break;
          case $b: $h = ($r - $g) / $d + 4; break;
      }
      $h /= 6;
  }

  return array($h, $s, $l);
}

function om_hsl2rgb($hsl) {
	$h = $hsl[0];
	$s = $hsl[1];
	$l = $hsl[2];

	if ($s == 0){
		$r = $g = $b = $l;
	}
	else {
		$q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
		$p = 2 * $l - $q;
		$r = om_hue2rgb($p, $q, $h + 1/3);
		$g = om_hue2rgb($p, $q, $h);
		$b = om_hue2rgb($p, $q, $h - 1/3);
	}

	return array(round($r * 255), round($g * 255), round($b * 255));
}

function om_hue2rgb($p, $q, $t){
	if ($t < 0) $t += 1;
	if ($t > 1) $t -= 1;
	if ($t < 1/6) return $p + ($q - $p) * 6 * $t;
	if ($t < 1/2) return $q;
	if ($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;
	return $p;
}

function om_parse2rgba($color) {
	$color=strtolower(trim($color));
	$rgba=false;
	if(substr($color,0,1) == '#') {
		$rgba=om_hex2rgb($color);
	} elseif(substr($color,0,4) == 'rgba') {
		$rgba=om_rgba2rgba($color);
	} elseif(substr($color,0,4) == 'rgb') {
		$rgba=om_rgb2rgb($color);
	}
	return $rgba;
}

function om_color_lightness($color, $k) {
	$rgba=om_parse2rgba($color);
	if(!$rgba)
		return $color;
	
	$hsl=om_rgb2hsl($rgba);
	$hsl[2]+=$k;
	if($hsl[2] < 0) {
		$hsl[2]=0;
	} elseif($hsl[2] > 1) {
		$hsl[2]=1;
	}
	$rgba_=om_hsl2rgb($hsl);
	if(isset($rgba[3])) {
		return 'rgba('.$rgba_[0].','.$rgba_[1].','.$rgba_[2].','.$rgba[3].')';
	} else {
		return 'rgb('.$rgba_[0].','.$rgba_[1].','.$rgba_[2].')';
	}
}

function om_rgba2string($rgba) {
	if(isset($rgba[3])) {
		return 'rgba('.$rgba[0].','.$rgba[1].','.$rgba[2].','.$rgba[3].')';
	} else {
		return 'rgb('.$rgba[0].','.$rgba[1].','.$rgba[2].')';
	}
}