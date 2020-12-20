<?php

namespace App\Http\Controllers;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MainController extends Controller
{
    
    // DASHBOARD
	public function index() {

		return view('super.index');
	}
	// users
	public function clientThemeAssign(){

		$userData = $this->getFromAPI('http://localhost:8000/api/getAllUsers');

		$user_rec = collect($userData->data);

		return view('super.client_theme', compact('user_rec'));

	}
	// Categories
	public function categories() {

		$categoriesData = $this->getFromAPI('http://encoderslab.com/iPasal/api/category');

		$start = 0;
		$end = 5;
		$categories = collect($categoriesData->data);

		return view('super.categories', compact('categories', 'start', 'end'));

	}

	public function show_category($id) {
		return view('super.details');
	}

	private function getFromAPI($url)
	{

		try {
			
			$client = new Client();

	        $response = $client->request('GET', $url);

	        $data = $response->getBody();

	        $data = json_decode($data);

        return $data;

		} catch (GuzzleException $e) {
			$response = $e->getResponse();
    		$responseBodyAsString = $response->getBody()->getContents();
			return $responseBodyAsString;
		}

	}

}
