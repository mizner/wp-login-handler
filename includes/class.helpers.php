<?php

namespace Knoxweb\WPLH;

class Helpers {

	public static function array_to_object( $array ) {
		$data = new \stdClass();
		foreach ( $array as $key => $value ) {
			$data->$key = $value;
		}

		return $data;

	}
}