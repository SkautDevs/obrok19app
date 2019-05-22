// urlB64ToUint8Array is a magic function that will encode the base64 public key
// to Array buffer which is needed by the subscription option
const urlB64ToUint8Array = base64String => {
	const padding = '='.repeat((4 - (base64String.length % 4)) % 4)
	const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/')
	const rawData = atob(base64)
	const outputArray = new Uint8Array(rawData.length)
	for (let i = 0; i < rawData.length; ++i) {
		outputArray[i] = rawData.charCodeAt(i)
	}
	return outputArray
}

const saveSubscription = async subscription => {
	const SERVER_URL = 'http://localhost:8080/save-subscription'
	const response = await fetch(SERVER_URL, {
		method: 'post',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify(subscription),
	})
	return response.json()
}

self.addEventListener('activate', async () => {

    // setInterval(function () {
    //     console.log('time 5000');
    //     if (Notification.permission === 'granted') {
    //         showServiceNotification('Yolo', 'muhehe', self.registration)
    //     }
    //
    // }, 5000);


	// // This will be called only once when the service worker is installed for first time.
	// try {
	// 	const applicationServerKey = urlB64ToUint8Array(
	// 		'BGLgNoLbVnRVGRvmJ45BAT2N8DLhd2nfUo3AlKDGshBxHqA4QJKUE9iEZmAHnUYVOQ_9JjwYOXl19pKQ7W7QN9I'
	// 	)
	// 	const options = { applicationServerKey, userVisibleOnly: true }
	// 	const subscription = await self.registration.pushManager.subscribe(options)
	// 	const response = await saveSubscription(subscription)
	// 	console.log(response)
	// } catch (err) {
	// 	console.log('Error', err)
	// }
});

// self.addEventListener('push', function(event) {
// 	if (event.data) {
// 		console.log('Push event!! ', event.data.text())
// 		showServiceNotification('Yolo', event.data.text(), self.registration)
// 	} else {
// 		console.log('Push event but no data')
// 	}
// });

const showServiceNotification = (title, body, swRegistration) => {
    const options = {
        'body': body,
        'icon': 'images/Obrok19_minilogo.png',
        'vibrate': [
            150, 50, 150, 50, 150, 150, // O
            150, 50, 50, 50, 50, 50, 50, 150, // B
            50, 50, 150, 50, 50, 150, // R
            150, 50, 150, 50, 150, 150, // O
            150, 50, 50, 50, 150, // K
        ],
    };

    swRegistration.showNotification(title, options);
}
