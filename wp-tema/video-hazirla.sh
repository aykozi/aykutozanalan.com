#!/bin/bash
# kullanım: hazirla.sh girdi.mp4 cikti_adi genislik [baslangic_sn] [sure_sn]
set -e
IN="$1"; NAME="$2"; W="$3"; SS="${4:-0}"; D="${5:-12}"; X=1.5
OUT=/tmp/aoa/wp-tema/aoa-dergi/assets/video; mkdir -p "$OUT"
F="scale=${W}:-2,fps=24,format=gray,boxblur=1:1,eq=contrast=0.9,format=yuv420p"
# sonu başına yumuşakça bindirerek kesintisiz döngü
FC="[0:v]trim=start=${SS}:duration=${D},setpts=PTS-STARTPTS,${F},split[a][b];[a]trim=start=${X},setpts=PTS-STARTPTS[main];[b]trim=duration=${X},setpts=PTS-STARTPTS[head];[main][head]xfade=transition=fade:duration=${X}:offset=$(echo "$D-2*$X" | bc)[v]"
ffmpeg -y -loglevel error -i "$IN" -filter_complex "$FC" -map "[v]" -an -c:v libx264 -preset veryfast -crf 30 -movflags +faststart "$OUT/$NAME.mp4"
ffmpeg -y -loglevel error -i "$OUT/$NAME.mp4" -an -c:v libvpx-vp9 -b:v 0 -crf 42 -row-mt 1 -deadline good -cpu-used 4 "$OUT/$NAME.webm"
ffmpeg -y -loglevel error -i "$OUT/$NAME.mp4" -frames:v 1 -q:v 5 "$OUT/$NAME.jpg"
ls -la "$OUT"/$NAME.*
