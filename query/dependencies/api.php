<?php
$version = 2.8;
//merge these arrays becuz i sed so
	if(isset($settings))
	{
		$settings = array_merge($settings, $_GET);
	}
	else
	{
		$settings = $_GET;
	}
//
//Minecraft User list - Based off of xPaw's (Pavel's) Minecraft server status	
		include('themes/style.php');
// Set the player get as $usr if the get is specified
	if(isset($settings['player']))
	{
		$usr = $settings['player'];
	}
//Include the xPaws mine query php and start echoing everyone on-line the specified server in the settings.ini
	include ('MinecraftQuery.class.php');
	$Query = new MinecraftQuery( );
	try
	{
		if(isset($settings['ip']))
		{
			if(isset($settings['port']))
			{
				$port = $settings['port'];
			}
			else
			{
				$port = '25565';
			}
			$Query->Connect( $settings['ip'], $port );
		}
		$players = $Query->GetPlayers( );
		//if nobody is online it shall display this
		if(empty($players))
		{
			echo 'Nobody is online.';
		}
		//
		//otherwise
		else
		{
		//it will display this
			foreach($players as $player)
			{
				echo '
				<div class="player">'.$player;
				
				if(empty($settings['heads']) or $settings['heads'] !== 'false')
					{
					echo'
					<img class="head" src="https://minotar.net/avatar/'.$player.'" alt="'.$player.'"/>
					';
					}
					
				echo '
				</div>
				';
			}
		//
		}

	}

	catch( MinecraftQueryException $e )
	{
		echo 'Server Offline';
	}
?>