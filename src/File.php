<?php
namespace Never5\WPCarManager;

class File {

	/** @var String */
	private $file;

	public function __construct( $file ) {
		$this->file = $file;
	}

	/**
	 * Return plugin file
	 *
	 * @return String
	 */
	public function plugin_file() {
		return $this->file;
	}

	/**
	 * Return plugin path
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( $this->file ) );
	}

	/**
	 * Return plugin url
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	public function plugin_url( $path = '' ) {
		return plugins_url( $path, $this->file );
	}

	/**
	 * Return image URL for given image
	 *
	 * @param $image
	 *
	 * @return string
	 */
	public function image_url( $image ) {
		return $this->plugin_url( '/assets/images/' . $image );
	}

	/**
	 * Return plugin dirname
	 *
	 * @return string
	 */
	public function dirname() {
		return dirname( plugin_basename( $this->file ) );
	}
}