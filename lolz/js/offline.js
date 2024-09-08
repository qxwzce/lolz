addEventListener('fetch', fetchEvent => {
  const request = fetchEvent.request;
  fetchEvent.respondWith(
    // Сначала попытка запросить его из Сети
    fetch(request)
    .then( responseFromFetch => {
      return responseFromFetch;
    }) // конец fetch.then
    // Если не сработало, то...
    .catch( fetchError => {
      // пытаемся найти в кеше
      caches.match(request)
      .then( responseFromCache => {
        if (responseFromCache) {
         return responseFromCache;
       // если не сработало и...
       } else {
         // это запрос к веб-странице, то...
         if (request.headers.get('Accept').includes('text/html')) {
           // покажите вашу офлайн-страницу
           return caches.match('/browse_errors/offline.php');
         } // 1конец if
       } // конец if/else
     }) // конец match.then
   }) // конец fetch.catch
  ); // конец respondWith
}); // конец addEventListener