<?php

use \Parsedown;
	/*
	|--------------------------------------------------------------------------
	| Docs Controller
	|--------------------------------------------------------------------------
	| Read Docs .md extentions 
	|
	| @author     Abdul Hafidz Anhsari
 	| @since      02/04/2014
 	| @version    0.1
 	| @category   Application
 	| @package    Default
	|
	*/

class DocsController extends BaseController {

	/*  Reader Docs  
	 *  
	 *
	 */

	public function read($chapter = null)
	{
		if ($chapter === null) $chapter = 'introduction';

		$data = array(
			'chapter'	=> $chapter,
			'index'		=> 'documentation'
		);

		try {

			// We use Markdown Extra for parsing, this library has been
			// included from the package composer.json.
			$parsedown = new Parsedown();
			// Walk through the data array, loading documentation from
			// the filesystem and converting it to markdown for display
			// on the documentation pages.
			
			array_walk($data, function(&$raw) use ($parsedown) {
				$path = base_path().'/docs';
				$raw = File::get($path."/{$raw}.md");
				$raw = $parsedown->parse($raw);
			});

		}
		catch (Exception $e) {

			// Catch all exceptions and abort the application with the 404
			// status command which will show our 404 page.
			//App::abort(404);
			return $e;

		}

		// Parse the index to find out the next and previous pages and add links to them in the footer
		$dom = new DOMDocument();
		$dom->loadHTML($data['index']);

		$indexlink = array();

		$domLinks = $dom->getElementsByTagName('a');
		foreach ($domLinks as $domLink) {

			$link['URI'] = $domLink->getAttribute('href');
			$link['title'] = $domLink->nodeValue;
			
			array_push($indexlink, array('uri'=> $link['URI'], 'title'=> $link['title']));
		}

		$data['index'] = $indexlink;
 		
 		// Show the documentation template, which extends our master template
		// and provides a documentation index within the sidebar section.
		return View::make('docs', $data);
	}

}