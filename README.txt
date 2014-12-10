Create Database:

# createdb flac
# psql flac << __EOF
CREATE TABLE snds (idx SERIAL,fname CHARACTER VARYING);
CREATE TABLE frames (snd_idx INTEGER,frame INTEGER,"offset" INTEGER,bits INTEGER,blocksize INTEGER,sample_rate INTEGER,channels INTEGER,channel_assignment CHARACTER VARYING);
CREATE TABLE subframes (snd_idx INTEGER,frame INTEGER,subframe INTEGER,wasted_bits INTEGER,"type" CHARACTER VARYING,"order" INTEGER,qlp_coeff_precision INTEGER, quantization_level INTEGER,residual_type CHARACTER VARYING, partition_order INTEGER);
CREATE TABLE parms (snd_idx INTEGER,frame INTEGER,subframe INTEGER,parm CHARACTER VARYING,parm_idx INTEGER,val INTEGER);
__EOF

