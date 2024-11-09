#!/bin/false

x3dom_version=1.8.3

echo -n "renderers/x3dom: x3dom.js & x3dom.css... "
if [ ! -e renderers/x3dom/x3dom.js ]; then
  cd deps
  x3dom_tarball=x3dom-${x3dom_version}
 
  if [ ! -e ${x3dom_tarball}.zip ]; then
    wget -c https://www.x3dom.org/download/${x3dom_version}/${x3dom_tarball}.zip
  fi
  if [ ! -d x3dom ]; then
    mkdir -p x3dom
    unzip ${x3dom_tarball}.zip -d x3dom
  fi  
  cp x3dom/x3dom.js  ../renderers/x3dom
  cp x3dom/x3dom.css ../renderers/x3dom
  
  cd ../uxs/faster-than-quick/js
  if [ ! -e x3dom.js ]; then
    ln -s ../../../renderers/x3dom/x3dom.js
  fi
  cd ../css
  if [ ! -e x3dom.css ]; then
    ln -s ../../../renderers/x3dom/x3dom.css
  fi
  echo "done"
  cd ../../..
else
  echo "already installed"
fi
