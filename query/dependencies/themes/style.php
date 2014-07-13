<?php
	
	if(empty($settings['color']))
	{
		$color = 'black';
	}
	else
	{
		$color = $settings['color'];
	}

	
	

	if(empty($settings['patternurl']))
		{
			$pattern = 'dependencies/bg.png';
		}
		else
		{
			$pattern = $settings['patternurl'];
		}
echo '
<style scoped>
*{
transition:.5s;
-webkit-transition:.5s;
font-family: Ubuntu, sans-serif;
}
body {
background-color:#1d1d1d;
color:#585656;
}

.player {
display:block;
line-height: 31px;
height:31px;
/*width:25px;*/
position:relative;
text-align:left;
/*border:3px solid '.$color.';*/
cursor:pointer;
margin: 0 0 5px 0;
}

.player:hover .head { 
background-color:rgba(0, 0, 0, 0.2);
border:3px solid white;
}

.head:hover {
background-color:rgba(0, 0, 0, 0.2);
border:3px solid white;
}
.head {
border:3px solid '.$color.';
float:left;
display:block;
width:25px;
height:25px;
margin: 0 10px 0 0;
}

#cover {
position:fixed;
top:0px;
left:0px;
width:100%;
height:100%;
background-color:rgba(0, 0, 0, 0.0);
animation: ani 0.5s;
-webkit-animation: ani 0.5s; /* Safari and Chrome */
}
@keyframes ani
{
from {opacity:0;}
to {opacity:1;}
}
@-webkit-keyframes ani /* Safari and Chrome */
{
from {opacity:0;}
to {opacity:1;}
}
#frown {
font-size:20px;
color:#242424;
}
#float {
position:absolute;
left:50%;
padding:10px;
margin-left:-30%;
top:100px;
width:60%;
animation: ani 0.5s;
-webkit-animation: ani 0.5s; /* Safari and Chrome */
margin-bottom:200px;
border-radius:30px;
border:3px solid '.$color.';
background-color:rgba(0, 0, 0, .50);
}
#title {
color:white;
font-size:80px;
}
hr { 
height: 1px;
border: 0;
background: '.$color.';
background: -webkit-gradient(linear, 0 0, 100% 0, from(transparent), to(transparent), color-stop(50%, '.$color.'));
}
#floatttl {
font-size:18px;
color:#242424;
padding-bottom:10px;
}
#hide {
display:none;
}
#floatitm {
font-size:30px;
text-align:left;
}
#link,a {
color:gray;
text-decoration:none;
}
#ex {
border-radius:100%;
border:2px solid gray;
font-size:25px;
color:gray;
position:absolute;
right:10px;
top:8px;
padding-right:8px;
padding-left:8px;
text-decoration:none;
}
#ex:hover {
color:'.$color.';
border:2px solid '.$color.';
}
#skin {
width:223px;
height:446px;
margin-left:auto;
margin-right:auto;
background-position:0 0;
}
#footer {
box-shadow:inset 0px 5px 5px rgba(0, 0, 0, 0.3);	
bottom:0px;
left:0px;
height:25px;
border-top:0px solid rgba(0, 0, 0, 0.2);
width:100%;
background-image:url(\''.$pattern.'\');
position:fixed;
background-color:black;
}
#footer2 {
background-color: rgba(0, 0, 0, 0.2);
position: absolute;
color:gray;
top: 0;
padding-top:3px;
left: 0;
width: 100%;
height: 100%;
}
#skin:hover {
background-position:224px 0;
}
</style>';

?>