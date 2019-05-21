<?php

namespace App;

use \GuzzleHttp\Client;


class HttpService {
    /**
     * @var Client
     */
	private $httpClient;

    /**
     * HttpService constructor.
     */
	public function __construct() {
		$this->httpClient = new Client([
			'base_uri' => 'https://registrace.obrok19.cz/api/program/',
            'verify' => false,
		]);
	}

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
	public function getSectionsOnline(): array {
		$json = $this->httpClient->request('GET', 'sections');
		$sectionsArray = json_decode($json->getBody(), true);
		$output = [];
		foreach ($sectionsArray as $section) {
			$output[$section['id']] = $section;
		}

		return $output;
	}

    /**
     * @return array
     */
	public function getSectionsLocal(): array {
		return [
			10 => [
				'title' => 'Putování',
				'id' => 10,
			],
            12 => [
                'title' => 'Večerní programy',
                'id' => 12,
            ],
            13 => [
                'title' => 'Doprovodné programy',
                'id' => 13,
            ],
			1 => [
				'title' => 'Služba',
				'id' => 1,
			],
			2 => [
				'title' => 'Vzlet',
				'id' => 2,
			],
			11 => [
				'title' => 'Pamětníci',
				'id' => 11,
			],
            14 => [
                'title' => 'M(a)y Day',
                'id' => 14,
            ],
            15 => [
                'title' => 'Velká hra',
                'id' => 15,
            ],
            16 => [
                'title' => 'EXPO',
                'id' => 16,
            ],
			3 => [
				'title' => 'Vapro',
				'subTitle' => '1. blok',
				'id' => 3,
			],
			4 => [
				'title' => 'Vapro',
				'subTitle' => '2. blok',
				'id' => 4,
			],
            17 => [
                'title' => 'Netradiční sporty',
                'id' => 17,
            ],

            18 => [
                'title' => 'Mše',
                'id' => 18,
            ],
		];
	}

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
	public function getPrograms(): array {
		$json = $this->httpClient->request('GET');
		return json_decode($json->getBody(), true);
	}

    /**
     * @param int $skautisUserID
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getProgramsForSkautisUser(int $skautisUserID): array {
        $json = $this->httpClient->request('GET', 'skautis-user/' . $skautisUserID);
        return json_decode($json->getBody(), true);
    }
}
