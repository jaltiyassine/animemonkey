// const iframeVideo = document.getElementById("iframe-video");
// const videoPlaceholder = document.getElementById("video-placeholder");

// if (iframeVideo) {
//     const url = '/check-working-server';
//     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

//     fetch(url, {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'Accept': 'application/json',
//             'X-CSRF-TOKEN': csrfToken,
//         },
//         body: JSON.stringify({ links: servers_l }),
//     })
//     .then(response => {
//         if (!response.ok) {
//             throw new Error(`HTTP error! Status: ${response.status}`);
//         }
//         return response.json();
//     })
//     .then(validLinks => {
//         console.log(validLinks);
//         iframeVideo.setAttribute('src', validLinks[0].link);
//         videoPlaceholder.remove();
//     })
//     .catch(error => {
//         console.error('Error:', error);
//     });
// }
