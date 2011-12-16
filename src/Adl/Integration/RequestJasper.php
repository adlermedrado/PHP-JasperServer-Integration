<?php
namespace Adl\Integration;

class RequestJasper
{
	private $jasperServer;
	
	public function __construct()
	{
		$parser = new \Adl\Config\Parser();
		$this->jasperServer = $parser->getConfig();
	}
	
	private function _requestMock($report, $format, $params)
	{

		if (is_array($params)) {
		    $reportParams = "";
		    foreach ($params as $name => $value) {
		        $reportParams .= "<parameter name=\"$name\"><![CDATA[$value]]></parameter>\n";
		    }
		} else {
			$reportParams = '';
		}
		
		$xmlTemplate = <<<XML_TEMPLATE
		<request operationName="runReport" locale="en">
			<argument name="RUN_OUTPUT_FORMAT">{$format}</argument>
			<resourceDescriptor name="" wsType="" uriString="{$report}" isNew="false">
				<label>null</label>
				{$reportParams}
			</resourceDescriptor>
		</request>
XML_TEMPLATE;
		return $xmlTemplate;
	}
	
	public function run($reportName,$formatType = 'PDF', $reportParams = null, $saveFile = false)
	{
		$client = new \SoapClient($this->jasperServer->getWsdl(), 
								 array('login' => $this->jasperServer->getUsername(), 
								 'password' => $this->jasperServer->getPassword(), 
								 "trace" => 1, "exceptions" => 0)
					   );

		$client->runReport($this->_requestMock($reportName, $formatType, $reportParams));
		
		preg_match('/boundary="(.*?)"/', $client->__getLastResponseHeaders(), $gotcha);

		$bound = $gotcha[1];
		
		$invokeReturnPart = explode($bound, $client->__getLastResponse());

		$output = substr($invokeReturnPart[2], (strpos($invokeReturnPart[2], '<report>') + 9));

		$content = trim(str_replace("\n--","",$output));
		if ($saveFile === true) {
			$filename = $this->jasperServer->getPathToSave() . DIRECTORY_SEPARATOR . 'generate_report_at_'.time().".{$formatType}";
			file_put_contents($filename, $content);
			return $filename; 
		} else {
			return $content;
		}
	}	
}

/*
Copyright (C) 2011 Adler Brediks Medrado

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/