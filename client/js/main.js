import markerSDK from '@marker.io/browser';

if (window.markerio) {
    await markerSDK.loadWidget({
        destination: window.markerio
    }).then(() => {
        document.getElementById('markerio-id').remove();
    })
}

