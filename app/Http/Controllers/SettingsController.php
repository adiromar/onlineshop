<?php

namespace App\Http\Controllers;
use App\Setting;

use Illuminate\Http\Request;
use Session;
use Image;
use DB;

class SettingsController extends Controller
{
    
	public function index()
	{

		$setting = Setting::first();
		if ( $setting ) {
			$shippingcost = DB::table('shipping_type')->first();
			return view('settings.edit', compact('setting', 'shippingcost'));
		}

		return view('settings.create');

	}

	public function store(Request $request)
	{
		
		$this->validateWith([
			'siteName' => 'required',
			'siteLogo' => 'image',
			'aboutUs' => 'required',
			'privacyPolicy' => 'required'
		]);

		$file = $request->file('siteLogo');
		if ( $file ) {
			$filename = 'site-logo-' . str_slug( $request->siteName ) . '-' . str_random(8) . '.' . $file->getClientOriginalExtension();

			Image::make($file)->save('uploads/'. $filename);

			$sitelogo = 'uploads/' . $filename;

		}

		$contacts = [];
		if ( $request->name && $request->contactNo ) {
			$i = 0;
			$contactNos = $request->contactNo;
			$locations = $request->location;
			foreach ($request->name as $name) {
				
				$contacts[$i]['name'] = $name;
				$contacts[$i]['contactNo'] = $contactNos[$i];

			if ( isset($locations[$i]) ) {
				$contacts[$i]['location'] = $locations[$i];	
			}

				$i++;
			}
		}

		$sociallinks = [];

		if ( $request->facebookLink ) {
			$sociallinks['facebook'] = $request->facebookLink;
		}

		if ( $request->twitterLink ) {
			$sociallinks['twitter'] = $request->twitterLink;
		}

		if ( $request->youtubeLink ) {
			$sociallinks['youtube'] = $request->youtubeLink;
		}
		
		$setting = new Setting;

		$setting->siteName = $request->siteName;
		$setting->siteLogo = $sitelogo;
		$setting->aboutUs = $request->aboutUs;
		$setting->copyrightText = $request->copyrightText;
		$setting->privacyPolicy = $request->privacyPolicy;
		if ( count($sociallinks) > 0 ) {
			$setting->socialLinks = json_encode($sociallinks, JSON_UNESCAPED_UNICODE);
		}
		if ( $request->name && $request->contactNo ) {
			$setting->contacts = json_encode($contacts, JSON_UNESCAPED_UNICODE);
		}

		$setting->save();

		Session::flash('success', 'Succesfully updated setting.');

		return redirect()->back();

	}

	public function update(Request $request, $id)
	{

		$this->validateWith([
			'siteName' => 'required',
			'siteLogo' => 'image',
			'aboutUs' => 'required',
			'privacyPolicy' => 'required',
			'shippingcost' => 'required'
		]);

		$setting = Setting::find($id);

		$file = $request->file('siteLogo');
		if ( $file ) {
			$filename = 'site-logo-' . str_slug( $request->siteName ) . '-' . str_random(8) . '.' . $file->getClientOriginalExtension();

			Image::make($file)->save('uploads/'. $filename);

			$sitelogo = 'uploads/' . $filename;

		}

		$contacts = [];
		if ( $request->name && $request->contactNo ) {
			$i = 0;
			$contactNos = $request->contactNo;
			$locations = $request->location;
			foreach ($request->name as $name) {
				
				$contacts[$i]['name'] = $name;
				$contacts[$i]['contactNo'] = $contactNos[$i];

			if ( isset($locations[$i]) ) {
				$contacts[$i]['location'] = $locations[$i];	
			}

				$i++;
			}
		}

		$sociallinks = [];

		if ( $request->facebookLink ) {
			$sociallinks['facebook'] = $request->facebookLink;
		}

		if ( $request->twitterLink ) {
			$sociallinks['twitter'] = $request->twitterLink;
		}

		if ( $request->youtubeLink ) {
			$sociallinks['youtube'] = $request->youtubeLink;
		}
		

		$setting->siteName = $request->siteName;
		if ($file) {
			$setting->siteLogo = $sitelogo;
		}
		
		$setting->aboutUs = $request->aboutUs;
		$setting->copyrightText = $request->copyrightText;
		$setting->privacyPolicy = $request->privacyPolicy;
		if ( count($sociallinks) > 0 ) {
			$setting->socialLinks = json_encode($sociallinks, JSON_UNESCAPED_UNICODE);
		}
		if ( $request->name && $request->contactNo ) {
			$setting->contacts = json_encode($contacts, JSON_UNESCAPED_UNICODE);
		}

		$setting->save();

		
		DB::table('shipping_type')->where('shipping_id', $request->shippingTypeId)->update(['rate' => $request->shippingcost]);
		

		Session::flash('success', 'Succesfully updated setting.');

		return redirect()->back();

	}

}
