#!/bin/sh

# change .git/config:
#        #url = https://github.com/Alzymologist/wasm-js.git
#        url = git@github.com:Alzymologist/wasm-js.git

#git checkout -b better-init
#git push
#exit

#git clone git@github.com:Alzymologist/shave-rust.git

git status
git add .
git commit -m "add: flush.sh for flushing all caches, temp folders & other shits"
git push


# git@github.com:lleokaganov/Kalatori-frontend-plugins.git