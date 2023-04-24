<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
	public function tearDown(): void
	{
		parent::tearDown();
		\Mockery::close();
	}

	/**
	 * Test Request::request().
	 *
	 * @return void
	 */
	public function testRequestRequest()
	{
		/*
				$client = new  \Supabase\Storage\StorageClient('somekey', 'some_ref_id');
				$this->assertEquals('https://some_ref_id.supabase.co/storage/v1', $client->__getUrl());
				$this->assertEquals($client->__getHeaders(), [
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer somekey',
					'Content-Type' => 'application/json',
				]);
		*/
	}

	/**
	 * Test Request::handleError().
	 *
	 * @return void
	 */
	public function testHandleError()
	{
		/*
				$client = new  \Supabase\Storage\StorageClient('somekey', 'some_ref_id');
				$this->assertEquals('https://some_ref_id.supabase.co/storage/v1', $client->__getUrl());
				$this->assertEquals($client->__getHeaders(), [
					'X-Client-Info' => 'storage-php/0.0.1',
					'Authorization' => 'Bearer somekey',
					'Content-Type' => 'application/json',
				]);
		*/
	}
}
