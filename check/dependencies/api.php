<?php
$version = 2.8;

// Merge the settings and GET arrays
if ( isset( $settings ) ) {
	$settings = array_merge($settings, $_GET);
} else {
	$settings = $_GET;
}

// Grab minecraft user list
include( 'themes/style.php' );

// Set the player get as $usr if the get is specified
if( isset( $settings[ 'player' ] ) ) {
	$usr = $settings[ 'player' ];
}

// Start check for server status and user list
include( 'MinecraftQuery.class.php' );
$Query = new MinecraftQuery();

try {

	if ( isset( $settings['ip'] ) ) {

		if ( isset( $settings[ 'port' ] ) ) {
			$port = $settings[ 'port' ];
		} else {
			$port = '25565';
		}

		$Query->Connect( $settings['ip'], $port );

	}

	// Grab players that are online
	$players = $Query->GetPlayers();

	// Grab server info
	$info = $Query->GetInfo();

	if ( empty( $players ) ) {

		// Nobody is online
		echo '<h3>Nobody is online.</h3>';

	} else {

		// Display title
		echo '<h3>Online Users (' . $info['players'] . '/' . $info['Maxplayers'] . ')</h3>';

		// Display folks that are online
		foreach ( $players as $player ) {

			echo '<div class="player">' . $player;
			
			if ( empty( $settings[ 'heads' ] ) || $settings[ 'heads' ] !== 'false' ) {
				echo'<img class="head" src="https://minotar.net/avatar/' . $player . '" alt="' . $player . '">';
			}
				
			echo '</div>';

		}

	}

} catch( MinecraftQueryException $e ) {
	echo '<h3>Server Offline</h3>';
}