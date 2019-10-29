// service-worker.js
//
// N.B. : For reasons of scope, this file MUST be in the root directory
//(or a more general scope must be set) manually through "Service-Worker-Allowed"

self.addEventListener('install', function() {
  console.log('Install!');
});
self.addEventListener("activate", event => {
  console.log('Activate!');
});
self.addEventListener('fetch', function(event) {
  //console.log('Fetch!', event.request);
});
