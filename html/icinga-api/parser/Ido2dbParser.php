<?php
/*
* Class to parse the ido2db.cfg
*
* @author Michael Lübben <michael_luebben@web.de>
*/
class Ido2dbParser {

	// Default path to ido2db.cfg
	public $defaultPathToCfgFile = "/usr/local/icinga/etc/ido2db.cfg";
	
	// Temporary array for read in ido2db configuration file
	public $arrTmpCfgFile = NULL;
	public $arrCfgFile = NULL;
	
	// Array with allowed parameter in the configuration file
	protected $allowedParameters = array(
											"lock_file",
											"ndo2db_user",
											"ndo2db_group",
											"socket_type",
											"socket_name",
											"tcp_port",
											"db_servertype",
											"db_host",
											"db_port",
											"db_name",
											"db_prefix",
											"db_user",
											"db_pass",
											"max_timedevents_age",
											"max_systemcommands_age",
											"max_servicechecks_age",
											"max_hostchecks_age",
											"max_eventhandlers_age",
											"debug_level",
											"debug_verbosity",
											"debug_file",
											"max_debug_file_size");


	/*
	* public function __constructor
	*
	* @author Michael Lübben <michael_luebben@web.de>
	* @params string $setPathToCfgFile
	*/
	public function __construct($setPathToCfgFile = NULL) {
		if ($setPathToCfgFile === NULL) {
			$this->pathToCfgFile = $this->defaultPathToCfgFile;
		} else {
			$this->pathToCfgFile = $setPathToCfgFile;
		}
		$this->parseCfgFile();
	}
	
	
	/*
	* protected function parseCfgFile
	*
	* @author Michael Lübben <michael_luebben@web.de>
	*/
	protected function parseCfgFile() {
	
		// Read cfg file
		$this->arrTmpCfgFile = file($this->pathToCfgFile);
		
		// Remove comments and blank lines from array
		foreach ($this->arrTmpCfgFile as $line) {
			$line = trim($line);
			if (strlen($line) != 0) {
				if (substr($line,0,1) != "#") {
					$arrTmpParam = explode("=",$line);
					$this->arrCfgFile[$arrTmpParam[0]] = $arrTmpParam[1];
				}
			}
		}
	}
	
	
	/*
	* public function getConfigParameter
	*
	* @params string $param
	* @author Michael Lübben <michael_luebben@web.de>
	*/
	public function getConfigParameter($parameter) {
		if (!in_array($parameter, $this->allowedParameters)) {
			throw new Exception('Undefined parameter '.$parameter);
		} else {
			return $this->arrCfgFile[$parameter];
		}
	}

}

// extend exceptions
class parseIdo2dbException extends Exception {}
?>