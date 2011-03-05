<?php

require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-ftpext.php' );

class WP_Filesystem_FTPext_Fix extends WP_Filesystem_FTPext {
	function WP_Filesystem_FTPext_Fix( $opt='' ) {
		$this->__construct( $opt );
	}

	function __construct( $opt ) {
		parent::__construct( $opt );
	}

	function copy( $source, $destination, $overwrite = false ) {
		if ( !$overwrite && $this->exists( $destination ) )
			return false;
		$content = $this->get_contents( $source );
		if ( false === $content )
			return false;
		return $this->put_contents( $destination, $content, FS_CHMOD_FILE );
	}

	function delete( $file, $recursive = false, $type = false ) {
		if ( empty( $file ) )
			return false;
		if ( 'f' == $type || $this->is_file( $file ) )
			return @ftp_delete( $this->link, $file );
		if ( !$recursive )
			return @ftp_rmdir( $this->link, $file );

		$filelist = $this->dirlist( trailingslashit( $file ) );
		if ( !empty( $filelist ) )
			foreach ( $filelist as $delete_file )
				$this->delete( trailingslashit( $file ) . $delete_file['name'], $recursive, $delete_file['type'] );
		return @ftp_rmdir( $this->link, $file );
	}
}
