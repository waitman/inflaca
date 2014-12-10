<?php

error_reporting(E_ERROR);

$f=$argv[1];

if ($f=='') {
	echo 'usage: inflacana.php filename'."\n";
	exit(1);
}

$db=pg_connect('dbname=flac');

$this_frame = 0;
$this_subframe = 0;
$this_sndidx = 0;

$sql = "SELECT idx FROM snds WHERE fname=".pg_escape_literal($f);
$res = pg_query($db,$sql);
if (pg_num_rows($res)>0) {
	/* reprocess some sound file */
	$row = pg_fetch_array($res);
	$this_sndidx = $row[0];
	pg_free_result($res);
	$sql = "DELETE FROM frames WHERE snd_idx=".$this_sndidx;
	pg_query($db,$sql);
	$sql = "DELETE FROM subframes WHERE snd_idx=".$this_sndidx;
	pg_query($db,$sql);
	$sql = "DELETE FROM parms WHERE snd_idx=".$this_sndidx;
	pg_query($db,$sql);
} else {
	$sql = "INSERT INTO snds (idx,fname) VALUES (DEFAULT,".pg_escape_literal($f).") RETURNING idx";
	$res = pg_query($db,$sql);
	$row = pg_fetch_array($res);
	$this_sndidx=$row[0];
	pg_free_result($res);
}

echo 'processing: '.$this_sndidx."\n";

$x=file($f);
foreach ($x as $v) {
	$v=str_replace("\n",'',$v);
	$l=explode("\t",$v);

	$q=array();
	foreach ($l as $n) {
		if (strstr($n,'=')) {
			$dx=explode('=',$n);
			$q[array_shift($dx)]=array_pop($dx);
		}
	}
	if ($l[0]!='') { 		/* frame */
		$this_frame = $q['frame'];
		$sql = "INSERT INTO frames (snd_idx,frame,\"offset\",bits,blocksize,sample_rate,channels,channel_assignment)
			 VALUES (".$this_sndidx.",".intval($this_frame).",".intval($q['offset']).",".
			 intval($q['bits']).",".intval($q['blocksize']).",".intval($q['sample_rate']).",".
			 intval($q['channels']).",".pg_escape_literal($q['channel_assignment']).")";
		pg_query($db,$sql);
	} else {
		if ($l[1]!='') {	/* subframe */
			$this_subframe = $q['subframe'];
			$sql = "INSERT INTO subframes (snd_idx,frame,subframe,wasted_bits,\"type\",\"order\",qlp_coeff_precision,
				quantization_level,residual_type,partition_order) VALUES (".$this_sndidx.",".intval($this_frame).",".
				intval($this_subframe).",".intval($q['wasted_bits']).",".pg_escape_literal($q['type']).",".
				intval($q['order']).",".intval($q['qlp_coeff_precision']).",".intval($q['quantization_level']).",".
				pg_escape_literal($q['residual_type']).",".intval($q['partition_order']).")";
			pg_query($db,$sql);
		} else {
			$h=array_keys($q);
			$px=explode('[',$h[0]);
			$parm = array_shift($px);
			$vx=explode(']',array_pop($px));
			$parm_idx = array_shift($vx);
			$sql = "INSERT INTO parms(snd_idx,frame,subframe,parm,parm_idx,val) VALUES (".$this_sndidx.",".intval($this_frame).",".
				intval($this_subframe).",".pg_escape_literal($parm).",".intval($parm_idx).",".intval($q[$h[0]]).")";
			pg_query($db,$sql);
		}
	}
	
}

//EOF
