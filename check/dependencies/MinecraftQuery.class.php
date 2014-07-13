<?php
class MinecraftQueryException extends Exception {
	// Exception thrown by MinecraftQuery class
}

class MinecraftQuery {

	const STATISTIC = 0x00;
	const HANDSHAKE = 0x09;
	
	private $socket;
	private $players;
	private $info;
	
	public function Connect( $ip, $port = 25565, $timeout = 3 ) {

		if( !is_int( $timeout ) || $timeout < 0 ) {
			throw new InvalidArgumentException( 'Timeout must be an integer.' );
		}
		
		$this->socket = @FSockOpen( 'udp://' . $ip, (int)$port, $ErrNo, $ErrStr, $timeout );
		
		if( $ErrNo || $this->socket === false ) {
			throw new MinecraftQueryException( 'Could not create socket: ' . $ErrStr );
		}
		
		Stream_Set_Timeout( $this->socket, $timeout );
		Stream_Set_Blocking( $this->socket, true );
		
		try {

			$Challenge = $this->GetChallenge();
			$this->GetStatus( $Challenge );

		} catch( MinecraftQueryException $e ) {

			FClose( $this->socket );
			throw new MinecraftQueryException( $e->getMessage() );

		}
		
		FClose( $this->socket );

	}
	
	public function GetInfo() {
		return isset( $this->info ) ? $this->info : false;
	}
	
	public function GetPlayers() {
		return isset( $this->players ) ? $this->players : false;
	}
	
	private function GetChallenge() {

		$data = $this->WriteData( self::HANDSHAKE );
		
		if( $data === false ) {
			if(isset($_GET['port'])) { $port = $_GET['port']; } else { $port = 25565; }
			throw new MinecraftQueryException( '<div style="color:white;">Server Offline.... or its broke</div>' );
		}
		
		return pack( 'N', $data );

	}
	
	private function GetStatus( $Challenge ) {

		$data = $this->WriteData( self :: STATISTIC, $Challenge . pack( 'c*', 0x00, 0x00, 0x00, 0x00 ) );
		
		if( !$data ) {
			throw new MinecraftQueryException( 'Failed to receive status.' );
		}
		
		$last = '';
		$info = array();
		
		$data    = substr( $data, 11 ); // splitnum + 2 int
		$data    = explode( "\x00\x00\x01player_\x00\x00", $data );
		
		if( count( $data ) !== 2 ) {
			throw new MinecraftQueryException( 'Failed to parse server\'s response.' );
		}
		
		$players = substr( $data[ 1 ], 0, -2 );
		$data    = explode( "\x00", $data[ 0 ] );
		
		// array with known keys in order to validate the result
		// It can happen that server sends custom strings containing bad things (who can know!)
		$keys = array(
			'hostname'   => 'HostName',
			'gametype'   => 'GameType',
			'version'    => 'Version',
			'plugins'    => 'Plugins',
			'map'        => 'Map',
			'numplayers' => 'players',
			'maxplayers' => 'Maxplayers',
			'hostport'   => 'HostPort',
			'hostip'     => 'HostIp'
		);
		
		foreach( $data as $key => $value ) {

			if( ~$key & 1 ) {

				if( !array_key_exists( $value, $keys ) ) {
					$last = false;
					continue;
				}
				
				$last = $keys[ $value ];
				$info[ $last ] = '';

			} else if( $last != false ) {

				$info[ $last ] = $value;

			}

		}
		
		// Ints
		$info[ 'players' ]    = intval( $info[ 'players' ] );
		$info[ 'Maxplayers' ] = intval( $info[ 'Maxplayers' ] );
		$info[ 'HostPort' ]   = intval( $info[ 'HostPort' ] );
		
		// Parse "plugins", if any
		if( $info[ 'Plugins' ] ) {

			$data = explode( ": ", $info[ 'Plugins' ], 2 );
			
			$info[ 'RawPlugins' ] = $info[ 'Plugins' ];
			$info[ 'Software' ]   = $data[ 0 ];
			
			if( count( $data ) == 2 ) {
				$info[ 'Plugins' ] = explode( "; ", $data[ 1 ] );
			}

		} else {

			$info[ 'Software' ] = 'Vanilla';

		}
		
		$this->info = $info;
		
		if( $players ) {
			$this->players = explode( "\x00", $players );
		}

	}
	
	private function WriteData( $Command, $Append = "" ) {

		$Command = pack( 'c*', 0xFE, 0xFD, $Command, 0x01, 0x02, 0x03, 0x04 ) . $Append;
		$Length  = StrLen( $Command );
		
		if( $Length !== FWrite( $this->socket, $Command, $Length ) ) {
			throw new MinecraftQueryException( "Failed to write on socket." );
		}
		
		$data = FRead( $this->socket, 2048 );
		
		if( $data === false ) {
			throw new MinecraftQueryException( "Failed to read from socket." );
		}
		
		if( StrLen( $data ) < 5 || $data[ 0 ] != $Command[ 2 ] ) {
			return false;
		}
		
		return substr( $data, 5 );

	}

}