<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function browserDetect()
	{
		dd(\BrowserDetect::detect());
	}
	
	public function userAgent(Request $request)
	{
		dd($request->server('HTTP_USER_AGENT'));
	}
	
	public function ip(Request $request)
	{
		dd($request->ip());
	}
	
	public function branch()
	{
		dd($this->getGitBranch());
	}
	
	protected function getGitBranch()
	{
		$shellOutput = [];
		exec('git branch | ' . "grep ' * '", $shellOutput);
		foreach ($shellOutput as $line) {
			if (strpos($line, '* ') !== false) {
				return trim(strtolower(str_replace('* ', '', $line)));
			}
		}
		return null;
	}
	
	public function version()
	{
		dd($this->getGitVersion());
	}
	
	protected static function getGitVersion() 
	{
		exec('git describe --always',$version_mini_hash);
		exec('git rev-list HEAD | wc -l',$version_number);
		exec('git log -1',$line);
		$version['short'] = "v1.".trim($version_number[0]).".".$version_mini_hash[0];
		$version['full'] = "v1.".trim($version_number[0]).".$version_mini_hash[0] (".str_replace('commit ','',$line[0]).")";
		return $version;
	}
}
