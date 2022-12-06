<?php

namespace Supabase\Storage;

use Supabase\Util\Constants;
use Supabase\Util\Request;
use Supabase\Util\StorageError;

class StorageBucket
{
    protected string $url;
    protected array $headers = [];

    public function __construct($url, $headers)
    {
        $this->url = $url;
        $this->headers = array_merge(Constants::getDefaultHeaders(), $headers);
    }

    /**
     * List buckets in the project.
     * @access public
     * @return array
     */


    public function listBuckets()
    {
        $url = $this->url . '/bucket';

        try {
            $response = Request::request('GET', $url, $this->headers);
            return $response;
        } catch (\Exception $e) {
            if (StorageError::isStorageError($e)) {
                return [ 'data' => null, 'error' => $e ];
            }

            throw $e;
        }
    }

    /**
     * Get bucket details by bucketId.
     * @access public
     * @param string $bucketId The bucketId to get.
     * @return array
     */

    public function getBucket($bucketId)
    {
        try {
            $url = $this->url . '/bucket/' . $bucketId;
            $response = Request::request('GET', $url, $this->headers);
            return $response;
        } catch (\Exception $e) {
            if (StorageError::isStorageError($e)) {
                return [ 'data' => null, 'error' => $e ];
            }

            throw $e;
        }
    }

    /**
     * Create a new bucket.
     * @access public
     * @param string $bucketId The bucketId to create.
     */

    public function createBucket($bucketId, $options = ['public' => false])
    {
        try {
            $url = $this->url . '/bucket';
            $body = json_encode([
                'id' => $bucketId,
                'name' => $bucketId,
                'public' => $options['public'] ? 'true' : 'false'
            ]);
            $headers = array_merge($this->headers, ['Content-Type' => 'application/json']);
            $response = Request::request('POST', $url, $headers, $body);
            return $response;
        } catch (\Exception $e) {
            if (StorageError::isStorageError($e)) {
                return [ 'data' => null, 'error' => $e ];
            }

            throw $e;
        }
    }

    /**
     * Update bucket details by bucketId.
     * @access public
     * @param string $bucketId The bucketId to update.
     * @param array $options The options for the update.
     */

    public function updateBucket($bucketId, $options)
    {
        try {
            $body = json_encode([
                'id' => $bucketId,
                'name' => $bucketId,
                'public' => $options['public'] ? 'true' : 'false'
            ]);
            $url = $this->url . '/bucket/' . $bucketId;
            $headers = array_merge($this->headers, ['Content-Type' => 'application/json']);
            $response = Request::request('PUT', $url, $headers, $body);
            return $response;
        } catch (\Exception $e) {
            if (StorageError::isStorageError($e)) {
                return [ 'data' => null, 'error' => $e ];
            }

            throw $e;
        }
    }

    /**
     * Delete a bucket by bucketId.
     * @access public
     * @param string $bucketId The bucketId to delete.
     */

    public function deleteBucket($bucketId)
    {
        try {
            $url = $this->url . '/bucket/' . $bucketId;
            $response = Request::request('DELETE', $url, $this->headers);
            return $response;
        } catch (\Exception $e) {
            if (StorageError::isStorageError($e)) {
                return [ 'data' => null, 'error' => $e ];
            }

            throw $e;
        }
    }

    /**
     * Empties files out of bucket.
     * @access public
     * @param string $bucketId The bucketId to empty.
     */

    public function emptyBucket($bucketId)
    {
        try {
            $url = $this->url . '/bucket/' . $bucketId . '/empty';
            $response = Request::request('POST', $url, $this->headers);
            return $response;
        } catch (\Exception $e) {
            if (StorageError::isStorageError($e)) {
                return [ 'data' => null, 'error' => $e ];
            }

            throw $e;
        }
    }
}
