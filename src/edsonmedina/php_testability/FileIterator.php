<?php
/**
 * FileIterator 
 * This class deals with file iteration
 * @author Edson Medina <edsonmedina@gmail.com>
 */

namespace edsonmedina\php_testability;

class FileIterator 
{
	private $baseDir;
	private $analyser;

	private $processedFiles;
	private $excludedFiles;

	/**
	 * Runs the static analyser
	 * @param  string $baseDir Codebase directory
	 * @param  Analyser $analyser Static code analysis class
	 */
	public function __construct ($baseDir, AnalyserInterface $analyser)
	{
		$this->baseDir  = $baseDir;
		$this->analyser = $analyser;
	}

	/**
	 * Iterate files
	 */
	public function run ()
	{
		$this->processedFiles = 0;
		$this->excludedFiles  = 0;

		$this->iterate ($this->baseDir);
	}

	/** 
	 * Scans (recursively) the path and runs the analyser for each file
	 * @param  string $path File or directory
	 */
	public function iterate ($path)
	{
		if (is_dir ($path) && !$this->isDirExcluded($path)) 
		{
			// recurse into directory
			foreach (new \DirectoryIterator ($path) as $fileInfo)
			{
				if ($fileInfo->isDot()) {
					continue;
				}

				$this->iterate ($path.DIRECTORY_SEPARATOR.$fileInfo->getFilename());
			}
		}
		elseif (is_file ($path) && !$this->isFileExcluded($path))
		{
			// process file
			echo ".";
			$this->analyser->scan ($path);
			$this->processedFiles++;
		}
	}

	/**
	 * Exclude filter for directories
	 */
	private function isDirExcluded ($path)
	{
		if (basename($path) == '.git') {
			return true;
		}

		if (basename($path) == 'vendor') {
			return true;
		}

		return false;
	}

	/**
	 * Exclude filter for files
	 */
	private function isFileExcluded ($path)
	{
		if (substr($path, -4, 4) != '.php') {
			$this->excludedFiles++;
			return true;
		}

		return false;
	}

	/**
	 * getter for processedFiles
	 * @return int
	 */
	public function getProcessedFiles ()
	{
		return $this->processedFiles;
	}

	/**
	 * getter for excludedFiles
	 * @return int
	 */
	public function getExcludedFiles ()
	{
		return $this->excludedFiles;
	}
}