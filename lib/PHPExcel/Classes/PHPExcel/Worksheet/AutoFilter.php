<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2013 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Worksheet
 * @copyright  Copyright (c) 2006 - 2013 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.9, 2013-06-02
 */


/**
 * PHPExcel_Worksheet_AutoFilter
 *
 * @category   PHPExcel
 * @package    PHPExcel_Worksheet
 * @copyright  Copyright (c) 2006 - 2013 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Worksheet_AutoFilter
{
	/**
	 * Autofilter Worksheet
	 *
	 * @var PHPExcel_Worksheet
	 */
	private $_workSheet = NULL;


	/**
	 * Autofilter Range
	 *
	 * @var string
	 */
	private $_range = '';


	/**
	 * Autofilter Column Ruleset
	 *
	 * @var array of PHPExcel_Worksheet_AutoFilter_Column
	 */
	private $_columns = array();


    /**
     * Create a new PHPExcel_Worksheet_AutoFilter
	 *
	 *	@param	string		$pRange		Cell range (i.e. A1:E10)
	 * @param PHPExcel_Worksheet $pSheet
     */
    public function __construct($pRange = '', PHPExcel_Worksheet $pSheet = NULL)
    {
		$this->_range = $pRange;
		$this->_workSheet = $pSheet;
    }

	/**
	 * Get AutoFilter Parent Worksheet
	 *
	 * @return PHPExcel_Worksheet
	 */
	public function getParent() {
		return $this->_workSheet;
	}

	/**
	 * Set AutoFilter Parent Worksheet
	 *
	 * @param PHPExcel_Worksheet $pSheet
	 * @return PHPExcel_Worksheet_AutoFilter
	 */
	public function setParent(PHPExcel_Worksheet $pSheet = NULL) {
		$this->_workSheet = $pSheet;

		return $this;
	}

	/**
	 * Get AutoFilter Range
	 *
	 * @return string
	 */
	public function getRange() {
		return $this->_range;
	}

	/**
	 *	Set AutoFilter Range
	 *
	 *	@param	string		$pRange		Cell range (i.e. A1:E10)
	 *	@throws	PHPExcel_Exception
	 *	@return PHPExcel_Worksheet_AutoFilter
	 */
	public function setRange($pRange = '') {
		// Uppercase coordinate
		$cellAddress = explode('!',strtoupper($pRange));
		if (count($cellAddress) > 1) {
			list($worksheet,$pRange) = $cellAddress;
		}

		if (strpos($pRange,':') !== FALSE) {
			$this->_range = $pRange;
		} elseif(empty($pRange)) {
			$this->_range = '';
		} 