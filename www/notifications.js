const check = () => {
	if (!('serviceWorker' in navigator)) {
		throw new Error('No Service Worker support!')
	}
	if (!('PushManager' in window)) {
		throw new Error('No Push API Support!')
	}
};

const registerServiceWorker = async () => {
	return await navigator.serviceWorker.register('service.js')
};

const requestNotificationPermission = async () => {
	const permission = await window.Notification.requestPermission();
	// value of permission can be 'granted', 'default', 'denied'
	// granted: user has accepted the request
	// default: user has dismissed the notification permission popup by clicking on x
	// denied: user has denied the request.
	if (permission !== 'granted') {
		throw new Error('Permission not granted for Notification')
	}
};

const showLocalNotification = async (title, body, swRegistration) => {
	const options = {
		'body': body,
		'icon': 'images/Obrok19_minilogo.png',
		// 'vibrate': [
		// 	150, 50, 150, 50, 150, 150, // O
		// 	150, 50, 50, 50, 50, 50, 50, 150, // B
		// 	50, 50, 150, 50, 50, 150, // R
		// 	150, 50, 150, 50, 150, 150, // O
		// 	150, 50, 50, 50, 150, // K
		// ],
	};

    await swRegistration.showNotification(title, options);
};

const mainNotification = async () => {
	check();
	const swRegistration = await registerServiceWorker();
	const permission = await requestNotificationPermission();

	await showLocalNotification(
		'Super, teď už ti na Obroku nic neujde!',
		'Nezapomeň prozkoumat ostatní části appky!',
		swRegistration,
	);

	document.getElementById('notification-info').classList.add('hide');
};
