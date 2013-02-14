<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 das Medienkombinat GmbH
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');
tx_rnbase::load('tx_phpunit_database_testcase');
require_once(t3lib_extMgm::extPath('mksearch').'lib/Apache/Solr/Service.php' );

/**
 * @author Hannes Bochmann
 */
class Apache_Solr_Service_testcase extends tx_phpunit_database_testcase {
	
	/**
	 * @group unit
	 */
	public function testCommitCallsSendRawPostWithWaitFlushParameterIfNotSolr4() {
		$service = $this->getMock(
			'Apache_Solr_Service', array('_sendRawPost')
		);
		$service->setSolrVersion(30);
		
		$expectedUrl = 'http://localhost:8180/solr/update?wt=json';
		$expectedRawPostWithWaitFlushParameter = 
			'<commit expungeDeletes="false" waitFlush="true" waitSearcher="true" />';
		$expectedTimeout = 3600;
		
		$service->expects($this->once())
			->method('_sendRawPost')
			->with($expectedUrl, $expectedRawPostWithWaitFlushParameter, $expectedTimeout);
		
		$service->commit();
	}
	
	/**
	 * @group unit
	 */
	public function testCommitCallsSendRawPostWithoutWaitFlushParameterIfSolr4() {
		$service = $this->getMock(
			'Apache_Solr_Service', array('_sendRawPost')
		);
		$service->setSolrVersion(40);
		
		$expectedUrl = 'http://localhost:8180/solr/update?wt=json';
		$expectedRawPostWithWaitFlushParameter = 
			'<commit expungeDeletes="false" waitSearcher="true" />';
		$expectedTimeout = 3600;
		
		$service->expects($this->once())
			->method('_sendRawPost')
			->with($expectedUrl, $expectedRawPostWithWaitFlushParameter, $expectedTimeout);
		
		$service->commit();
	}
	
	/**
	 * @group unit
	 */
	public function testOptimizeCallsSendRawPostWithWaitFlushParameterIfNotSolr4() {
		$service = $this->getMock(
			'Apache_Solr_Service', array('_sendRawPost')
		);
		$service->setSolrVersion(30);
		
		$expectedUrl = 'http://localhost:8180/solr/update?wt=json';
		$expectedRawPostWithWaitFlushParameter = 
			'<optimize waitFlush="true" waitSearcher="true" />';
		$expectedTimeout = 3600;
		
		$service->expects($this->once())
			->method('_sendRawPost')
			->with($expectedUrl, $expectedRawPostWithWaitFlushParameter, $expectedTimeout);
		
		$service->optimize();
	}
	
	/**
	 * @group unit
	 */
	public function testOptimizeCallsSendRawPostWithoutWaitFlushParameterIfSolr4() {
		$service = $this->getMock(
			'Apache_Solr_Service', array('_sendRawPost')
		);
		$service->setSolrVersion(40);
		
		$expectedUrl = 'http://localhost:8180/solr/update?wt=json';
		$expectedRawPostWithWaitFlushParameter = 
			'<optimize waitSearcher="true" />';
		$expectedTimeout = 3600;
		
		$service->expects($this->once())
			->method('_sendRawPost')
			->with($expectedUrl, $expectedRawPostWithWaitFlushParameter, $expectedTimeout);
		
		$service->optimize();
	}
}