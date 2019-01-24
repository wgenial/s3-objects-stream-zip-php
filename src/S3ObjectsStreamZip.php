<?php
  namespace WGenial\S3ObjectsStreamZip;

  use Aws\S3\Exception\S3Exception;
  use Aws\S3\S3Client;
  use WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException;
  use ZipStream\ZipStream;

  class S3ObjectsStreamZip
  {
    protected $auth = array();
    protected $s3Client;

    public function __construct($auth)
    {
      $this->authValidation($auth);
      $this->s3Client();
    }

    public function zipObjects($bucket, $objects, $zipname, $checkObjectExist = false)
    {
      $this->paramsValidation(array(
        "bucket" => $bucket,
        "objects" => $objects,
        "zipname" => $zipname,
        "checkObjectExist" => $checkObjectExist
      ));

      $zip = new ZipStream($zipname);

      foreach ($objects as $object) {
        $objectName = isset($object['name']) ? $object['name'] : basename($object['path']);

        $context = stream_context_create(array(
          's3' => array('seekable' => true)
        ));

        // https://docs.aws.amazon.com/aws-sdk-php/v3/guide/service/s3-stream-wrapper.html#downloading-data
        $objectDir = "s3://{$bucket}/{$object['path']}";

        if ($stream = fopen($objectDir, 'r', false, $context)) {
          $zip->addFileFromStream($objectName, $stream);
        }
      }

      $zip->finish();
    }

    protected function authValidation($auth)
    {
      if (!isset($auth['version']) || empty($auth['version'])) {
        throw new InvalidParamsException('$auth parameter to constructor requires a `version` attribute.');
      }

      if (!isset($auth['region']) || empty($auth['region'])) {
        throw new InvalidParamsException('$auth parameter to constructor requires a `region` attribute.');
      }

      if (!isset($auth['credentials']) || empty($auth['credentials'])) {
        throw new InvalidParamsException('$auth parameter to constructor requires a `credentials` attribute.');
      }

      if (!isset($auth['credentials']['key']) || empty($auth['credentials']['key'])) {
        throw new InvalidParamsException('$auth["credentials"] parameter to constructor requires a `key` attribute.');
      }

      if (!isset($auth['credentials']['secret']) || empty($auth['credentials']['secret'])) {
        throw new InvalidParamsException('$auth["credentials"] parameter to constructor requires a `secret` attribute.');
      }

      $this->auth = $auth;
    }

    protected function s3Client()
    {
      $s3Client = new S3Client(array(
        'version' => $this->auth['version'],
        'region' => $this->auth['region'],
        'credentials' => array(
          'key' => $this->auth['credentials']['key'],
          'secret' => $this->auth['credentials']['secret']
        )
      ));

      $this->s3Client = $s3Client;
      $this->s3Client->registerStreamWrapper();
    }

    protected function paramsValidation($params)
    {
      // bucket validation
      $this->bucketValidation($params["bucket"]);

      // objects validation
      $this->objectsValidation($params["bucket"], $params["objects"], $params["checkObjectExist"]);

      // zipname validation
      $this->zipnameValidation($params["zipname"]);
    }

    protected function bucketValidation($bucket)
    {
      if (!isset($bucket)) {
        throw new InvalidParamsException('The parameter `bucket` is required.');
      }
      else if (empty($bucket)) {
        throw new InvalidParamsException('The parameter `bucket` cannot be an empty string.');
      }

      try {
        // http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html#headbucket
        $this->s3Client->headBucket(array(
          'Bucket' => $bucket
        ));
      }
      catch (S3Exception $e) {
        throw new InvalidParamsException("Bucket `{$bucket}` does not exists and/or you have not permission to access it.");
      }
    }

    protected function objectsValidation($bucket, $objects, $checkObjectExist)
    {
      if (!isset($objects)) {
        throw new InvalidParamsException('The parameter `objects` is required.');
      }
      else if (!is_array($objects)) {
        throw new InvalidParamsException('The parameter `objects` must be an array.');
      }
      else if (empty($objects)) {
        throw new InvalidParamsException('The parameter `objects` cannot be an empty array.');
      }
      else if (!is_array(current($objects))) {
        throw new InvalidParamsException('The array `objects` requires a `path` attribute.');
      }

      foreach ($objects as $object) {
        if (!array_key_exists('path', $object)) {
          throw new InvalidParamsException('The array `objects` requires an nested array with `path` attribute.');
        }
        else if (empty($object['path'])) {
          throw new InvalidParamsException('The `path` cannot be an empty string.');
        }

        if ($checkObjectExist) {
          $this->doesObjectExist($bucket, $object);
        }
      }
    }

    protected function doesObjectExist($bucket, $object)
    {
      // https://docs.aws.amazon.com/aws-sdk-php/v3/guide/service/s3-stream-wrapper.html#other-object-functions
      $objectDir = "s3://{$bucket}/{$object['path']}";

      if (!file_exists($objectDir)) {
        throw new InvalidParamsException("The object `{$object['path']}` you have requested does not exist.");
      }
      else if (!is_file($objectDir)) {
        throw new InvalidParamsException("The action cannot be completed because `{$object['path']}` it's not an object.");
      }
    }

    protected function zipnameValidation($zipname)
    {
      if (!isset($zipname)) {
        throw new InvalidParamsException('The parameter `zipname` is required.');
      }
      else if (empty($zipname)) {
        throw new InvalidParamsException('The parameter `zipname` cannot be an empty string.');
      }
    }
}