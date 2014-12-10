Create Database:

# createdb flac
# psql flac << __EOF
CREATE TABLE snds (idx SERIAL,fname CHARACTER VARYING);
CREATE TABLE frames (snd_idx INTEGER,frame INTEGER,"offset" INTEGER,bits INTEGER,blocksize INTEGER,sample_rate INTEGER,channels INTEGER,channel_assignment CHARACTER VARYING);
CREATE TABLE subframes (snd_idx INTEGER,frame INTEGER,subframe INTEGER,wasted_bits INTEGER,"type" CHARACTER VARYING,"order" INTEGER,qlp_coeff_precision INTEGER, quantization_level INTEGER,residual_type CHARACTER VARYING, partition_order INTEGER);
CREATE TABLE parms (snd_idx INTEGER,frame INTEGER,subframe INTEGER,parm CHARACTER VARYING,parm_idx INTEGER,val INTEGER);
__EOF


example data

% psql flac -c "SELECT * FROM frames"
 snd_idx | frame | offset |  bits  | blocksize | sample_rate | channels | channel_assignment 
---------+-------+--------+--------+-----------+-------------+----------+--------------------
       1 |     0 |     42 | 273432 |      4096 |       88200 |        2 | INDEPENDENT
       1 |     1 |  34221 |  99928 |      4096 |       88200 |        2 | INDEPENDENT
       1 |     2 |  46712 | 107432 |      4096 |       88200 |        2 | INDEPENDENT
       1 |     3 |  60141 | 108472 |      4096 |       88200 |        2 | MID_SIDE
       1 |     4 |  73700 | 108776 |      4096 |       88200 |        2 | MID_SIDE
       1 |     5 |  87297 | 107752 |      4096 |       88200 |        2 | INDEPENDENT
       1 |     6 | 100766 | 107096 |      4096 |       88200 |        2 | INDEPENDENT
       1 |     7 | 114153 | 106440 |      4096 |       88200 |        2 | INDEPENDENT
       1 |     8 | 127458 | 111528 |      4096 |       88200 |        2 | MID_SIDE
       1 |     9 | 141399 | 117088 |      4096 |       88200 |        2 | MID_SIDE
       1 |    10 | 156035 | 112864 |      4096 |       88200 |        2 | INDEPENDENT
       1 |    11 | 170143 | 111808 |      4096 |       88200 |        2 | MID_SIDE
       1 |    12 | 184119 | 110904 |      4096 |       88200 |        2 | MID_SIDE
       1 |    13 | 197982 | 108904 |      4096 |       88200 |        2 | MID_SIDE
       1 |    14 | 211595 | 109848 |      4096 |       88200 |        2 | INDEPENDENT
       1 |    15 | 225326 | 113336 |      4096 |       88200 |        2 | INDEPENDENT
       1 |    16 | 239493 | 111384 |      4096 |       88200 |        2 | MID_SIDE
       1 |    17 | 253416 | 113584 |      4096 |       88200 |        2 | MID_SIDE

% psql flac -c "SELECT * FROM subframes"
 snd_idx | frame | subframe | wasted_bits | type  | order | qlp_coeff_precision | quantization_level | residual_type | partition_order 
---------+-------+----------+-------------+-------+-------+---------------------+--------------------+---------------+-----------------
       1 |     0 |        0 |           0 | LPC   |     8 |                  15 |                 15 | RICE          |               4
       1 |     0 |        1 |           0 | LPC   |     7 |                  15 |                 15 | RICE          |               4
       1 |     1 |        0 |           0 | LPC   |     8 |                  15 |                 14 | RICE          |               2
       1 |     1 |        1 |           0 | LPC   |     8 |                  15 |                 14 | RICE          |               4
       1 |     2 |        0 |           0 | LPC   |     6 |                  15 |                 13 | RICE          |               0
       1 |     2 |        1 |           0 | LPC   |     6 |                  15 |                 13 | RICE          |               0
       1 |     3 |        0 |           0 | LPC   |     6 |                  15 |                 13 | RICE          |               1
       1 |     3 |        1 |           0 | LPC   |     7 |                  15 |                 13 | RICE          |               1
       1 |     4 |        0 |           0 | LPC   |     6 |                  15 |                 13 | RICE          |               1
       1 |     4 |        1 |           0 | LPC   |     7 |                  15 |                 13 | RICE          |               1
       1 |     5 |        0 |           0 | LPC   |     6 |                  15 |                 13 | RICE          |               0
       1 |     5 |        1 |           0 | LPC   |     8 |                  15 |                 13 | RICE          |               0
       1 |     6 |        0 |           0 | LPC   |     8 |                  15 |                 13 | RICE          |               0
       1 |     6 |        1 |           0 | LPC   |     8 |                  15 |                 14 | RICE          |               0
       1 |     7 |        0 |           0 | LPC   |     8 |                  15 |                 13 | RICE          |               1
       1 |     7 |        1 |           0 | LPC   |     8 |                  15 |                 14 | RICE          |               1
       1 |     8 |        0 |           0 | LPC   |     7 |                  15 |                 13 | RICE          |               0
       1 |     8 |        1 |           0 | LPC   |     7 |                  15 |                 13 | RICE          |               0
       1 |     9 |        0 |           0 | LPC   |     3 |                  15 |                 12 | RICE          |               1
       1 |     9 |        1 |           0 | LPC   |     8 |                  15 |                 12 | RICE          |               1
       1 |    10 |        0 |           0 | FIXED |     2 |                   0 |                  0 | RICE          |               0
       1 |    10 |        1 |           0 | FIXED |     2 |                   0 |                  0 | RICE          |               0
       1 |    11 |        0 |           0 | FIXED |     2 |                   0 |                  0 | RICE          |               0
       1 |    11 |        1 |           0 | LPC   |     7 |                  15 |                 13 | RICE          |               0

% psql flac -c "SELECT * FROM parms"
 snd_idx | frame | subframe |   parm    | parm_idx |   val    
---------+-------+----------+-----------+----------+----------
       1 |     0 |        0 | qlp_coeff |        0 |    -3881
       1 |     0 |        0 | qlp_coeff |        1 |    -8405
       1 |     0 |        0 | qlp_coeff |        2 |     6477
       1 |     0 |        0 | qlp_coeff |        3 |     3673
       1 |     0 |        0 | qlp_coeff |        4 |     9939
       1 |     0 |        0 | qlp_coeff |        5 |     6549
       1 |     0 |        0 | qlp_coeff |        6 |     7132
       1 |     0 |        0 | qlp_coeff |        7 |     4987
       1 |     0 |        0 | warmup    |        0 |        0
       1 |     0 |        0 | warmup    |        1 |        0
       1 |     0 |        0 | warmup    |        2 |        0
       1 |     0 |        0 | warmup    |        3 |        0
       1 |     0 |        0 | warmup    |        4 |        0
       1 |     0 |        0 | warmup    |        5 |        0
       1 |     0 |        0 | warmup    |        6 |        0
       1 |     0 |        0 | warmup    |        7 |        1
       1 |     0 |        0 | parameter |        0 |        7
       1 |     0 |        0 | parameter |        1 |        8
       1 |     0 |        0 | parameter |        2 |        8
       1 |     0 |        0 | parameter |        3 |        8
       1 |     0 |        0 | parameter |        4 |        9
       1 |     0 |        0 | parameter |        5 |        9


