self.addEventListener('install', event => {
  console.log('Service Worker instalado.');
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  console.log('Service Worker activado.');
});

self.addEventListener('fetch', function(event) {
  // Esto intercepta las solicitudes, útil si luego querés cachear recursos
});
